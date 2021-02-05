<?php

namespace App\Domain\Book\Service;

use App\Domain\Book\Repository\BookViewerRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class BookViewer
{
    /**
     * @var BookViewerRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param BookViewerRepository $repository The repository
     */
    public function __construct(BookViewerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Affiche la liste de tous les livres
     *
     * @return array La liste de tous les livres
     */
    public function viewBook(): array
    {

        // Sélectionne tous les livres
        $books = $this->repository->selectAllBook();

        // Logging here: User created successfully
        //$this->logger->info(sprintf('User created successfully: %s', $books));

        return $books;
    }

    /**
     * Affiche un livre selon son id
     *
     * @return array La liste de tous les livres
     */
    public function viewBookById($id): array
    {

        // Sélectionne tous les livres
        $books = $this->repository->selectBookById($id);

        // Logging here: User created successfully
        //$this->logger->info(sprintf('User created successfully: %s', $books));

        return $books;
    }

}
