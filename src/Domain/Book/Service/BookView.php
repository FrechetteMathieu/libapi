<?php

namespace App\Domain\Book\Service;

use App\Domain\Book\Repository\BookViewRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class BookView
{
    /**
     * @var BookViewRepository
     */
    private $repository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * The constructor.
     *
     * @param BookViewRepository $repository The repository
     * @param LoggerFactory $logger The logger
     */
    public function __construct(BookViewRepository $repository, LoggerFactory $logger)
    {
        $this->repository = $repository;
        $this->logger = $logger
            ->addFileHandler('Books.log')
            ->createLogger("BookView");
    }

    /**
     * Affiche la liste de tous les livres
     *
     * @return array La liste de tous les livres
     */
    public function viewBook(array $queryParams): array
    {
        $pageNo = $queryParams['page'] ?? null;
        $nbLivreParPage = $queryParams['nblivres'] ?? 10;

        if(isset($pageNo)) {
            $books = $this->repository->selectAllBookWithPagination($pageNo, $nbLivreParPage);
            $nbBooksTotal = $this->repository->countBooks();
            $results = [
                "books" => $books,
                "page" => (int)$pageNo,
                "pageTotal" => ceil($nbBooksTotal / $nbLivreParPage),
                "nbLivreParPage" => (int)$nbLivreParPage
            ];
        } else {
            $results = $this->repository->selectAllBook();
        }

        return $results;
    }

    /**
     * Affiche un livre selon son id
     *
     * @return array La liste de tous les livres
     */
    public function viewBookById($id): array
    {
        $books = $this->repository->selectBookById($id);

        return $books[0] ?? [];
    }

    /**
     * Affiche tous les livres d'un auteur selon son id
     *
     * @return array La liste de tous les livres d'un auteur
     */
    public function viewBookByAuthorId($authorId): array
    {
        $books = $this->repository->selectBookByAuthorId($authorId);

        return $books;
    }

    /**
     * Affiche tous les livres qui ont le mot clé dans leur titre
     *
     * @return array La liste de tous les livres d'un auteur
     */
    public function viewBookByTitle($title): array
    {
        $books = $this->repository->selectBookByTitle($title);

        return $books;
    }

}
