<?php

namespace App\Domain\Author\Service;

use App\Domain\Author\Repository\AuthorViewRepository;

/**
 * Service.
 */
final class AuthorView
{
    /**
     * @var AuthorViewRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param AuthorViewRepository $repository The repository
     * @param LoggerFactory $logger The logger
     */
    public function __construct(AuthorViewRepository $repository)
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
}
