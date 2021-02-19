<?php

namespace App\Domain\Book\Service;

use App\Domain\Book\Repository\BookDeleteRepository;
use App\Domain\Book\Repository\BookViewRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class BookDelete
{
    /**
     * @var BookDeleteRepository
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
     * @param BookDeleteRepository $repository The repository
     */
    public function __construct(
        BookDeleteRepository $repository, 
        BookViewRepository $bookViewRepository, 
        LoggerFactory $logger)
    {
        $this->repository = $repository;
        $this->bookViewRepository = $bookViewRepository;
        $this->logger = $logger
            ->addFileHandler('Books.log')
            ->createLogger("BookDelete");
    }

    /**
     * Delete a book
     *
     * @param int $data The form data
     *
     * @return array The deleted book object
     */
    public function deleteBook(int $id): array
    {
        $deleteSucceed = false;
        $bookToDelete = $this->bookViewRepository->selectBookById($id);;

        if(!empty($bookToDelete)) {
            // Delete book
            $deleteSucceed = $this->repository->deleteBook($bookToDelete[0]['id']);
        }

        $this->logger->info("Le livre id [{$id}]" . ($deleteSucceed ? " a été supprimé" : " n'a pu être supprimé"));

        return $bookToDelete[0] ?? [];
    }

}
