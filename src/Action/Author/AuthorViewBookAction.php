<?php

namespace App\Action\Author;

use App\Domain\Book\Service\BookView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AuthorViewBookAction
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

        $authorId = $request->getAttribute('id',0);
    
        $books = $this->bookView->viewBookByAuthorId($authorId);

        $response->getBody()->write((string)json_encode($books));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
