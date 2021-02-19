<?php

namespace App\Action\Book;

use App\Domain\Book\Service\BookUpdate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class BookUpdateAction
{
    private $bookUpdate;

    public function __construct(BookUpdate $bookUpdate)
    {
        $this->bookUpdate = $bookUpdate;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        // Retrieve request parameter and body
        $id = $request->getAttribute('id', 0);
        $data = (array)$request->getParsedBody();
        // Update the book values
        $book = $this->bookUpdate->updateBook($id, $data);

        $response->getBody()->write((string)json_encode($book));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
