<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Middleware\BasicAuthMiddleware;
use Slim\App;
use App\Middleware\JwtAuthMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    
    $app->get('/', \App\Action\Docs\SwaggerUiAction::class)->setName('home');

    // Création d'un nouveau token d'authentification
    $app->post('/tokens', \App\Action\Auth\TokenCreateAction::class);
    // Documentation
    $app->get('/v1/docs', \App\Action\Docs\SwaggerUiAction::class);

    // Afficher la liste de tous les livres, on peut ajouter le paramêtre titre pour filtrer par titre
    $app->get('/books', \App\Action\Book\BookViewAction::class);
    // Afficher un livre selon son id
    $app->get('/books/{id}', \App\Action\Book\BookViewByIdAction::class);
    // Créer un nouveau livre
    $app->post('/books', \App\Action\Book\BookCreateAction::class);
    // Éditer les informations d’un livre
    $app->put('/books/{id}', \App\Action\Book\BookUpdateAction::class);
    // Supprimer un livre 
    $app->delete('/books/{id}', \App\Action\Book\BookDeleteAction::class);
    
    // Afficher la liste des auteurs
    $app->get('/authors', \App\Action\Author\AuthorViewAction::class)->add(BasicAuthMiddleware::class);
    // Liste tous les livres d’un auteur selon son id
    $app->get('/authors/{id}/books', \App\Action\Author\AuthorViewBookAction::class);
    // Créer un auteur
    $app->post('/authors', \App\Action\Author\AuthorCreateAction::class);
    // Modifier un auteur
    $app->put('/authors/{id}', \App\Action\Author\AuthorUpdateAction::class);
    // Supprimer un auteur
    $app->delete('/authors/{id}', \App\Action\Author\AuthorDeleteAction::class);   
    
};
