<?php

namespace App\Action\Author;

use App\Domain\Author\Service\AuthorDelete;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AuthorDeleteAction
{
    private $authorDelete;

    public function __construct(AuthorDelete $authorDelete)
    {
        $this->authorDelete = $authorDelete;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        // Collect input from the HTTP request
        $id = $request->getAttribute('id', 0);

        // Invoke the Domain with inputs and retain the result
        $authorDelete = $this->authorDelete->deleteAuthor($id);

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($authorDelete));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
