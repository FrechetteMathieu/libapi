<?php

namespace App\Action;

use App\Domain\Book\Service\BookViewer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class BookViewerAction
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
        $bookId = $request->getAttribute('id', 0);

        // Invoke the Domain with inputs and retain the result
        $books = $this->bookViewer->viewBook();

        // Transform the result into the JSON representation
        $result = [
            'books' => $books
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
