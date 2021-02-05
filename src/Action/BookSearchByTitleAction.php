<?php

namespace App\Action;

use App\Domain\Book\Service\BookSearcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class BookSearchByTitleAction
{
    private $BookSearcher;

    public function __construct(BookSearcher $BookSearcher)
    {
        $this->BookSearcher = $BookSearcher;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $book = $this->BookSearcher->searchBookByTitle($data);

        // Transform the result into the JSON representation
        $result = [
            'books' => $book
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
