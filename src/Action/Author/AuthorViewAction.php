<?php

namespace App\Action\Author;

use App\Domain\Author\Service\AuthorView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AuthorViewAction
{
    private $authorView;

    public function __construct(AuthorView $authorView)
    {
        $this->authorView = $authorView;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        $authors = $this->authorView->viewAuthors();

        $response->getBody()->write((string)json_encode($authors));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
