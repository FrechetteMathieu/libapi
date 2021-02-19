<?php

namespace App\Action\Book;

use App\Domain\Book\Service\BookDelete;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class BookDeleteAction
{
    private $BookDelete;

    public function __construct(BookDelete $BookDelete)
    {
        $this->BookDelete = $BookDelete;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        // Collect input from the HTTP request
        $id = $request->getAttribute('id', 0);

        // Invoke the Domain with inputs and retain the result
        $deleteBook = $this->BookDelete->deleteBook($id);
        
        $result = [
            'book' => $deleteBook
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($deleteBook));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
