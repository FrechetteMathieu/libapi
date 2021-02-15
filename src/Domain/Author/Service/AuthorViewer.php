<?php

namespace App\Domain\Author\Service;

use App\Domain\Author\Repository\AuthorViewerRepository;
use App\Domain\Book\Repository\BookViewerRepository;

/**
 * Service.
 */
final class AuthorViewer
{
    /**
     * @var AuthorViewerRepository
     */
    private $repository;

    /**
     * @var BookViewerRepository
     */
    private $bookViewerRepository;

    /**
     * The constructor.
     *
     * @param AuthorViewerRepository $repository The repository
     * @param LoggerFactory $logger The logger
     */
    public function __construct(
        AuthorViewerRepository $repository, 
        BookViewerRepository $bookViewerRepository,)
    {
        $this->repository = $repository;
    }

    /**
     * Affiche la liste de tous les auteurs
     *
     * @return array La liste de tous les auteurs
     */
    public function viewAuthors(): array
    {
        $books = $this->repository->selectAllAuthor();
        
        return $books;
    }

    /**
     * Affiche la liste de tous les auteurs
     *
     * @return array La liste de tous les auteurs
     */
    public function viewAuthorBooks($id): array
    {
        // $bookRepository = \App\Domain\Book\Repository\BookViewerRepository::class;
        $books = $bookRepository->selectAllAuthor();
        
        return $books;
    }

}
