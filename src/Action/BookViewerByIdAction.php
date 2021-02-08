<?php

namespace App\Action;

use App\Domain\Book\Service\BookViewer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class BookViewerByIdAction
{
    private $bookViewer;

    public function __construct(bookViewer $bookViewer)
    {
        $this->bookViewer = $bookViewer;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
        // Collect input from the HTTP request
        $id = $request->getAttribute('id', 0);

        // Invoke the Domain with inputs and retain the result
        $book = $this->bookViewer->viewBookById($id);

        // Transform the result into the JSON representation
        $result = [
            'books' => $book
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
