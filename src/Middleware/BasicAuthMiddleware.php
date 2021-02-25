<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Domain\Auth\Service\BasicAuthValidation;

class BasicAuthMiddleware
{

    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @var basicAuthValidation
     */
    private $basicAuthValidation;

    /**
     * The constructor.
     *
     * @param ResponseFactoryInterface $responseFactory The response factory
     */
    public function __construct(ResponseFactoryInterface $responseFactory, BasicAuthValidation $basicAuthValidation) {
        $this->responseFactory = $responseFactory;
        $this->basicAuthValidation = $basicAuthValidation;
    }
    
    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return ResponseInterface
     */
    public function __invoke(
        Request $request, 
        RequestHandler $handler): ResponseInterface
    {
        // Build response from the request. Will be used if authentification is valid.
        $response = $handler->handle($request);
        // Extract encode token from header
        $token = explode(' ', $request->getHeaderLine('Authorization'))[1] ?? '';

        if (!$this->basicAuthValidation->isTokenValid($token)) {
            // If the token is nor valid, return empty response qith status code 401
            return $this->responseFactory->createResponse()
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401, 'Unauthorized');
        }

        // Otherwise return unmodified response.
        return $response;
    }
}
