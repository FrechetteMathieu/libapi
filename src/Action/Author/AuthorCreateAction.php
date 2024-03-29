<?php

namespace App\Action\Author;

use App\Domain\Author\Service\AuthorCreate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AuthorCreateAction
{
    private $authorCreate;

    public function __construct(AuthorCreate $authorCreate)
    {
        $this->authorCreate = $authorCreate;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        $data = (array)$request->getParsedBody();

        $authorId = $this->authorCreate->createAuthor($data);
        $result = [
            'id' => $authorId
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201); // Le code d'état de la réponse
    }
}
