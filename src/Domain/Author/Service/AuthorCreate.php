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
        $this->validateBookData($data);

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
    private function validateBookData(array $data): void
    {
        $errors = [];

        

        // if (empty($data['username'])) {
        //     $errors['username'] = 'Input required';
        // }

        // if (empty($data['email'])) {
        //     $errors['email'] = 'Input required';
        // } elseif (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
        //     $errors['email'] = 'Invalid email address';
        // }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}
