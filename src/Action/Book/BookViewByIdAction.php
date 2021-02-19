<?php

namespace App\Action\Book;

use App\Domain\Book\Service\BookView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class BookViewByIdAction
{
    private $bookView;

    public function __construct(BookView $bookView)
    {
        $this->bookView = $bookView;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
        // Collect input from the HTTP request
        $id = $request->getAttribute('id', 0);

        // Invoke the Domain with inputs and retain the result
        $book = $this->bookView->viewBookById($id);

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($book));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
