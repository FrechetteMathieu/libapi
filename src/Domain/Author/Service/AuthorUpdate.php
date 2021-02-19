<?php

namespace App\Domain\Author\Service;

use App\Domain\Author\Repository\AuthorUpdateRepository;
use App\Domain\Author\Repository\AuthorViewRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class AuthorUpdate
{
    /**
     * @var AuthorUpdateRepository
     */
    private $repository;

    /**
     * @var AuthorViewRepository
     */
    private $authorViewRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * The constructor.
     *
     * @param AuthorUpdateRepository $repository The repository
     */
    public function __construct(
        AuthorUpdateRepository $repository, 
        AuthorViewRepository $authorViewRepository, 
        LoggerFactory $logger)
    {
        $this->repository = $repository;
        $this->authorViewRepository = $authorViewRepository;
        $this->logger = $logger
            ->addFileHandler('Author.log')
            ->createLogger("AuthorUpdate");
    }

    /**
     * Update an author
     *
     * @param int   $id     The id of the author to update
     * @param array $data   The author values to update
     *
     * @return array The author object updated
     */
    public function updateAuthor(int $id, array $data): array
    {
        $updateSucceed = false;
        // Validate if the book exist in the BD
        $bookId = $data['genreId'] ?? 0;
        //$authorToUpdate = $this->authorViewRepository->selec($bookId);

        if(!empty($authorToUpdate)) {
            // If there is no value for the field, keep the old value
            $data['genreId'] = $data['genreId'] ?? $authorToUpdate[0]['genreId'];
            $data['titre'] = $data['titre'] ?? $authorToUpdate[0]['titre'];
            $data['isbn'] = $data['isbn'] ?? $authorToUpdate[0]['isbn'];
            // Update book
            $updateSucceed = $this->repository->updateBook($authorToUpdate[0]['id'], $data);
        }

        // Retrieve the updated book
        $bookUpdated = $this->bookViewRepository->selectBookById($bookId);

        $this->logger->info("Le livre id [{$bookId}]" . ($updateSucceed ? " a été modifié" : " n'a pu être modifié"));

        return $bookUpdated[0];
    }

}
