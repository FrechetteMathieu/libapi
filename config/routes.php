<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class)->setName('home');

    $app->post('/users', \App\Action\UserCreateAction::class);

    $app->get('/docs/v1', \App\Action\Docs\SwaggerUiAction::class);

    // Afficher la liste de tous les livres
    $app->get('/books', \App\Action\BookViewerAction::class);
    // Afficher un livre selon son id
    $app->get('/books/{id}', \App\Action\BookViewerByIdAction::class);
    // Rechercher un livre par titre
    $app->post('/books/search', \App\Action\BookSearchByTitleAction::class);
    // Créer un nouveau livre
    $app->post('/books', \App\Action\BookCreateAction::class);
    // Éditer les informations d’un livre
    $app->put('/books/{id}', \App\Action\BookUpdateAction::class);
    // Supprimer un livre 
    $app->delete('/books/{id}', \App\Action\BookDeleteAction::class);
    
    // Afficher la liste des auteurs
    $app->get('/authors', \App\Action\AuthorViewAction::class);
    // Liste tous les livres d’un auteur selon son id
    $app->get('/authors/{id}/books', \App\Action\AuthorViewBookAction::class);
    // Créer un auteur
    // Modifier un auteur
    // Supprimer un auteur

    // Afficher la liste des genres
    // Liste tous les livres d’un genre selon son id
    // Créer un genre
    // Modifier un genre
    // Supprimer un genre
};
