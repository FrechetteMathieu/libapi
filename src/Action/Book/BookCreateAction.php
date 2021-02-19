<?php

namespace App\Action\Book;

use App\Domain\Book\Service\BookCreate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class BookCreateAction
{
    private $bookCreate;

    public function __construct(BookCreate $bookCreate)
    {
        $this->bookCreate = $bookCreate;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        $data = (array)$request->getParsedBody();

        $bookId = $this->bookCreate->createBook($data);
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
