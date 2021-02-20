<?php

use App\Factory\LoggerFactory;
use App\Routing\JwtAuth;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details']
        );
    },

    BasePathMiddleware::class => function (ContainerInterface $container) {
        return new BasePathMiddleware($container->get(App::class));
    },

    PDO::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['db'];
    
        $host = $settings['host'];
        $dbname = $settings['database'];
        $username = $settings['username'];
        $password = $settings['password'];
        $charset = $settings['charset'];
        $flags = $settings['flags'];
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    
        return new PDO($dsn, $username, $password, $flags);
    },

    LoggerFactory::class => function (ContainerInterface $container) {
        return new LoggerFactory($container->get('settings')['logger']);
    },
    
    // Twig templates
    Twig::class => function (ContainerInterface $container) {
        $settings = $container->get('settings');
        $twigSettings = $settings['twig'];
        $options = $twigSettings['options'];
        $options['cache'] = $options['cache_enabled'] ? $options['cache_path'] : false;
        $twig = Twig::create($twigSettings['paths'], $options);
        // Add extension here
        // ...
        return $twig;
    },
    TwigMiddleware::class => function (ContainerInterface $container) {
        return TwigMiddleware::createFromContainer(
            $container->get(App::class),
            Twig::class
        );
    },

    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getResponseFactory();
    },

    JwtAuth::class => function (ContainerInterface $container) {
        $configuration = $container->get(Configuration::class);

        $jwtSettings = $container->get('settings')['jwt'];
        $issuer = (string)$jwtSettings['issuer'];
        $lifetime = (int)$jwtSettings['lifetime'];

        return new JwtAuth($configuration, $issuer, $lifetime);
    },

    Configuration::class => function (ContainerInterface $container) {
        $jwtSettings = $container->get('settings')['jwt'];

        $privateKey = (string)$jwtSettings['private_key'];
        $publicKey = (string)$jwtSettings['public_key'];

        // Asymmetric algorithms use a private key for signature creation
        // and a public key for verification
        return Configuration::forAsymmetricSigner(
            new Sha256(),
            InMemory::plainText($privateKey),
            InMemory::plainText($publicKey)
        );
    },

];
