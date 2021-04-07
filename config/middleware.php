<?php

use Selective\BasePath\BasePathMiddleware;
use Slim\Views\TwigMiddleware;
use Slim\App;
use App\Middleware\RouteLogMiddleware;
use App\Middleware\JwtClaimMiddleware;

return function (App $app) {
    // Log enpoint access
    $app->add(RouteLogMiddleware::class);

    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    $app->add(JwtClaimMiddleware::class);
    $app->add(TwigMiddleware::class);

    // Ajoutez cette ligne
    $app->add(\App\Middleware\CorsMiddleware::class);
    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    // Add app base path
    $app->add(BasePathMiddleware::class);

    // Create a custom logger for the ErrorMiddleware
    $loggerFactory = $app->getContainer()->get(\App\Factory\LoggerFactory::class);
    $logger = $loggerFactory->addFileHandler('error.log')->createLogger();
    $app->addErrorMiddleware(true, true, true, $logger);   
};
