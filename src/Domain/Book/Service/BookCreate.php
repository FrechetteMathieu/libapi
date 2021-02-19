<?php

namespace App\Domain\Book\Service;

use App\Domain\Book\Repository\BookCreateRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class BookCreate
{
    /**
     * @var BookCreateRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param BookCreateRepository $repository The repository
     */
    public function __construct(BookCreateRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new book.
     *
     * @param array $data The form data
     *
     * @return int The new book ID
     */
    public function createBook(array $data): int
    {
        // Input validation
        $this->validateBookData($data);

        // Insert book
        $bookId = $this->repository->insertBook($data);

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
