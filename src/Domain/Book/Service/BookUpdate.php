<?php

namespace App\Domain\Book\Service;

use App\Domain\Book\Repository\BookUpdateRepository;
use App\Domain\Book\Repository\BookViewerRepository;
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
     * @var BookViewerRepository
     */
    private $bookViewerRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * The constructor.
     *
     * @param BookDeleteRepository $repository The repository
     */
    public function __construct(
        BookUpdateRepository $repository, 
        BookViewerRepository $bookViewerRepository, 
        LoggerFactory $logger)
    {
        $this->repository = $repository;
        $this->bookViewerRepository = $bookViewerRepository;
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
        $bookToUpdate = $this->bookViewerRepository->selectBookById($id);

        if(!empty($bookToUpdate)) {
            // If there is no value for the field, keep the old value
            $data['genreId'] = $data['genreId'] ?? $bookToUpdate[0]['genreId'];
            $data['titre'] = $data['titre'] ?? $bookToUpdate[0]['titre'];
            $data['isbn'] = $data['isbn'] ?? $bookToUpdate[0]['isbn'];
            // Update book
            $updateSucceed = $this->repository->updateBook($bookToUpdate[0]['id'], $data);
        }

        // Retrieve the updated book
        $bookUpdated = $this->bookViewerRepository->selectBookById($id);

        $this->logger->info("Le livre id [{$id}]" . ($updateSucceed ? " a été modifié" : " n'a pu être modifié"));

        $result = [
            'success' => $updateSucceed,
            'book' => $bookUpdated
        ];

        return $result;
    }

}
