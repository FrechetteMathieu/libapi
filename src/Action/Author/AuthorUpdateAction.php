<?php

namespace App\Action\Author;

use App\Domain\Author\Service\AuthorUpdate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AuthorUpdateAction
{
    private $authorUpdate;

    public function __construct(AuthorUpdate $authorUpdate)
    {
        $this->authorUpdate = $authorUpdate;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        $authorId = $request->getAttribute('id', 0);
        $data = (array)$request->getParsedBody();

        $author = $this->authorUpdate->updateAuthor($authorId, $data);

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($author));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201); // Le code d'état de la réponse
    }
}
