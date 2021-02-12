<?php

namespace App\Domain\Book\Repository;

use PDO;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Repository.
 */
class BookCreatorRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection, LoggerFactory $logger)
    {
        $this->connection = $connection;
        $this->logger = $logger
            ->addFileHandler('Books.log')
            ->createLogger("BookCreatorRepository");
    }

    /**
     * Insert book row.
     *
     * @param array $book The book
     *
     * @return int The new ID
     */
    public function insertBook(array $book): int
    {
        $params = [
            'genreId' => $book['genreId'] ?? 0,
            'titre' => $book['titre'] ?? '',
            'isbn' => $book['isbn'] ?? ''
        ];

        $sql = "INSERT INTO livres (genreId, titre, isbn) 
                VALUES (:genreId, :titre, :isbn)";

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $errorInfo = $query->errorInfo();
        if($errorInfo[0] != 0) {
            $this->logger->error($errorInfo[2]);
        }

        return (int)$this->connection->lastInsertId();
    }
}

