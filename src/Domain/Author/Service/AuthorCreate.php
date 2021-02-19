<?php

namespace App\Domain\Author\Service;

use App\Domain\Author\Repository\AuthorCreateRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class AuthorCreate
{
    /**
     * @var AuthorCreateRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param AuthorCreateRepository $repository The repository
     */
    public function __construct(AuthorCreateRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new author.
     *
     * @param array $data The form data
     *
     * @return int The new author ID
     */
    public function createAuthor(array $data): int
    {
        // Input validation
        $this->validateAuthorData($data);

        // Insert book
        $bookId = $this->repository->insertAuthor($data);

        return $bookId;
    }

    /**
     * Input validation.
     *
     * @param array $data The form data
     *
     * @throws ValidationException
     *
     * @return void
     */
    private function validateAuthorData(array $data): void
    {
        $errors = [];

        if(!isset($data['nom'])) {
            $errors['nom'] = 'Champs requis';
        }

        if(!isset($data['prenom'])) {
            $errors['prenom'] = 'Champs requis';
        }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}
