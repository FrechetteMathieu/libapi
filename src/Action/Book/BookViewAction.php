<?php

namespace App\Action\Book;

use App\Domain\Book\Service\BookView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class BookViewAction
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
        $queryParams = $request->getQueryParams();
        $title = $queryParams['titre'] ?? null;
        
        $books = isset($title) 
            ? $this->bookView->viewBookByTitle($title) 
            : $this->bookView->viewBook($queryParams);

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($books));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
