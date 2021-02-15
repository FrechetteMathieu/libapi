<?php

namespace App\Action;

use App\Domain\Author\Service\AuthorViewer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AuthorViewAction
{
    private $authorViewer;

    public function __construct(AuthorViewer $authorViewer)
    {
        $this->authorViewer = $authorViewer;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        $authors = $this->authorViewer->viewAuthors();

        $result = [
            'authors' => $authors
        ];

        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
