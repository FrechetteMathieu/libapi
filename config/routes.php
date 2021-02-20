<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use App\Middleware\JwtAuthMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    
    $app->get('/', \App\Action\Docs\SwaggerUiAction::class)->setName('home');

    // Création d'un nouveau token d'authentification
    $app->post('/tokens', \App\Action\Auth\TokenCreateAction::class);
    // Documentation
    $app->get('/v1/docs', \App\Action\Docs\SwaggerUiAction::class);


    $app->group('/v1', function(RouteCollectorProxy $group) {
        
        // Afficher la liste de tous les livres, on peut ajouter le paramêtre titre pour filtrer par titre
        $group->get('/books', \App\Action\Book\BookViewAction::class);
        // Afficher un livre selon son id
        $group->get('/books/{id}', \App\Action\Book\BookViewByIdAction::class);
        // Créer un nouveau livre
        $group->post('/books', \App\Action\Book\BookCreateAction::class);
        // Éditer les informations d’un livre
        $group->put('/books/{id}', \App\Action\Book\BookUpdateAction::class);
        // Supprimer un livre 
        $group->delete('/books/{id}', \App\Action\Book\BookDeleteAction::class); 

        // Afficher la liste des auteurs
        $group->get('/authors', \App\Action\Author\AuthorViewAction::class);
        // Liste tous les livres d’un auteur selon son id
        $group->get('/authors/{id}/books', \App\Action\Author\AuthorViewBookAction::class);
        // Créer un auteur
        $group->post('/authors', \App\Action\Author\AuthorCreateAction::class);
        // Modifier un auteur
        $group->put('/authors/{id}', \App\Action\Author\AuthorUpdateAction::class);
        // Supprimer un auteur
        $group->delete('/authors/{id}', \App\Action\Author\AuthorDeleteAction::class);

        // Afficher la liste des genres
        // Liste tous les livres d’un genre selon son id
        // Créer un genre
        // Modifier un genre
        // Supprimer un genre
    
    })->add(JwtAuthMiddleware::class);;
    
    
    
    
    
};
