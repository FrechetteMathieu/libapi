<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class)->setName('home');

    $app->post('/users', \App\Action\UserCreateAction::class);

    // Afficher la liste de tous les livres
    $app->get('/books', \App\Action\BookViewerAction::class);
    // Afficher un livre selon son id
    $app->get('/books/{id}', \App\Action\BookViewerByIdAction::class);
    // Rechercher un livre par titre
    $app->post('/books/search', \App\Action\BookSearchByTitleAction::class);
    // Créer un nouveau livre
    $app->post('/books/add', \App\Action\BookCreateAction::class);
    // Éditer les informations d’un livre
    $app->put('/books/{id}', \App\Action\BookUpdateAction::class);
    // Supprimer un livre 
    $app->delete('/books/{id}', \App\Action\BookDeleteAction::class);

};

