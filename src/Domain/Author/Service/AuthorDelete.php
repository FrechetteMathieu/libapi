<?php

namespace App\Domain\Author\Service;

use App\Domain\Author\Repository\AuthorDeleteRepository;
use App\Domain\Author\Repository\AuthorViewRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class AuthorDelete
{
    /**
     * @var AuthorDeleteRepository
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
     * @param AuthorDeleteRepository $repository The repository
     */
    public function __construct(
        AuthorDeleteRepository $repository, 
        AuthorViewRepository $authorViewRepository,
        LoggerFactory $logger)
    {
        $this->repository = $repository;
        $this->authorViewRepository = $authorViewRepository;
        $this->logger = $logger
            ->addFileHandler('Authors.log')
            ->createLogger("AuthorDelete");
    }

    /**
     * Delete an author
     *
     * @param int $data The form data
     *
     * @return array The deleted author object
     */
    public function deleteAuthor(int $id): array
    {
        $deleteSucceed = false;
        $authorToDelete = $this->authorViewRepository->selectAuthor($id);;

        if(!empty($authorToDelete)) {
            // Delete book
            $deleteSucceed = $this->repository->deleteAuthor($authorToDelete[0]['id']);
        }

        $this->logger->info("L'auteur id [{$id}]" . ($deleteSucceed ? " a été supprimé" : " n'a pu être supprimé"));

        return $authorToDelete[0] ?? [];
    }

}
