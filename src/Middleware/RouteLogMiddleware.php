<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;
use Slim\Routing\RouteContext;

class RouteLogMiddleware
{
    
    /**
     * @var LoggerInterface
     */
    private $logger;
    
    /**
     * Constructor.
     *
     * @param LoggerFactory $logger Logger object
     */
    public function __construct(LoggerFactory $logger)
    {
        $this->logger = $logger
            ->addFileHandler('routes.log')
            ->createLogger("RouteLogMiddleware");
    }

    /**
     * Enpoint access logging
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(
        Request $request, 
        RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();
        $routeMethod = $route->getMethods()[0] ?? "";

        $routeURI = $request->getUri()->getPath() ?? "";
        $routeQuery = empty($request->getUri()->getQuery()) ? "" : "?" . $request->getUri()->getQuery();

        $this->logger->info("{$routeMethod} {$routeURI}{$routeQuery}");
    
        return $response;
    }
}
