<?php

namespace App\Action\Author;

use App\Domain\Author\Service\Service\BookCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AuthorCreateAction
{
    private $bookCreator;

    public function __construct(BookCreator $bookCreator)
    {
        $this->bookCreator = $bookCreator;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        $data = (array)$request->getParsedBody();

        $bookId = $this->bookCreator->createBook($data);
        $result = [
            'id' => $bookId
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201); // Le code d'état de la réponse
    }
}
