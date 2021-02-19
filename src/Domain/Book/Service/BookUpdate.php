<?php

namespace App\Domain\Book\Service;

use App\Domain\Book\Repository\BookUpdateRepository;
use App\Domain\Book\Repository\BookViewRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class BookUpdate
{
    /**
     * @var BookUpdateRepository
     */
    private $repository;

    /**
     * @var BookViewRepository
     */
    private $bookViewRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * The constructor.
     *
     * @param BookUpdateRepository $repository The repository
     */
    public function __construct(
        BookUpdateRepository $repository, 
        BookViewRepository $bookViewRepository, 
        LoggerFactory $logger)
    {
        $this->repository = $repository;
        $this->bookViewRepository = $bookViewRepository;
        $this->logger = $logger
            ->addFileHandler('Books.log')
            ->createLogger("BookUpdate");
    }

    /**
     * Update a book
     *
     * @param int   $id     The id of the book to update
     * @param array $data   The book values to update
     *
     * @return array The book object updated
     */
    public function updateBook(int $id, array $data): array
    {
        $updateSucceed = false;
        // Validate if the book exist in the BD
        $bookToUpdate = $this->bookViewRepository->selectBookById($id);

        if(!empty($bookToUpdate)) {
            // If there is no value for the field, keep the old value
            $data['genreId'] = $data['genreId'] ?? $bookToUpdate[0]['genreId'];
            $data['titre'] = $data['titre'] ?? $bookToUpdate[0]['titre'];
            $data['isbn'] = $data['isbn'] ?? $bookToUpdate[0]['isbn'];
            // Update book
            $updateSucceed = $this->repository->updateBook($id, $data);
        }

        // Retrieve the updated book
        $bookUpdated = $this->bookViewRepository->selectBookById($id);

        $this->logger->info("Le livre id [{$id}]" . ($updateSucceed ? " a été modifié" : " n'a pu être modifié"));

        return $bookUpdated[0];
    }

}
