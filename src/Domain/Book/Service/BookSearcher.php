<?php

namespace App\Domain\Book\Service;

use App\Domain\Book\Repository\BookSearcherRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class BookSearcher
{
    /**
     * @var BookSearcherRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param BookSearcherRepository $repository The repository
     */
    public function __construct(BookSearcherRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Recherche un livre
     *
     * @return array La liste de tous les livres qui répondent à la recherche
     */
    public function searchBookByTitle(array $data): array
    {

        // Effectue la recherche de livres
        $books = isset($data['titre']) ? $this->repository->searchBookByTitle($data) : [];

        return $books;
    }

}
