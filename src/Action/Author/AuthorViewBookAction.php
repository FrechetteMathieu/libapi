<?php

namespace App\Action\Author;

use App\Domain\Book\Service\BookViewer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AuthorViewBookAction
{
    private $bookViewer;

    public function __construct(BookViewer $bookViewer)
    {
        $this->bookViewer = $bookViewer;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        $authorId = $request->getAttribute('id',0);
    
        $books = $this->bookViewer->viewBookByAuthorId($authorId);

        $result = [
            'books' => $books
        ];

        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
