<?php

namespace App\Domain\Book\Service;

use App\Domain\Book\Repository\BookViewerRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class BookViewer
{
    /**
     * @var BookViewerRepository
     */
    private $repository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * The constructor.
     *
     * @param BookViewerRepository $repository The repository
     * @param LoggerFactory $logger The logger
     */
    public function __construct(BookViewerRepository $repository, LoggerFactory $logger)
    {
        $this->repository = $repository;
        $this->logger = $logger
            ->addFileHandler('Books.log')
            ->createLogger("BookViewer");
    }

    /**
     * Affiche la liste de tous les livres
     *
     * @return array La liste de tous les livres
     */
    public function viewBook(): array
    {
        $books = $this->repository->selectAllBook();
        
        return $books;
    }

    /**
     * Affiche un livre selon son id
     *
     * @return array La liste de tous les livres
     */
    public function viewBookById($id): array
    {
        $books = $this->repository->selectBookById($id);

        return $books;
    }

}
