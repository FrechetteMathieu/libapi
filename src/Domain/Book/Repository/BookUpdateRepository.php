<?php

namespace App\Domain\Book\Repository;

use PDO;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Repository.
 */
class BookUpdateRepository
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
            ->createLogger("BookUpdateRepository");
    }

    /**
     * Update a book
     *
     * @param array $is The book id to update
     *
     * @return bool Is the query succeed
     */
    public function updateBook(int $id, array $book): bool
    {

        $params = [
            'id' => $id,
            'genreId' => $book['genreId'],
            'titre' => $book['titre'],
            'isbn' => $book['isbn']
        ];

        $sql = "UPDATE livres SET 
                genreId=:genreId, 
                titre=:titre, 
                isbn=:isbn
                WHERE id = :id;";

        $query = $this->connection->prepare($sql);
        $result = $query->execute($params);

        $errorInfo = $query->errorInfo();
        if($errorInfo[0] != 0) {
            $this->logger->error($errorInfo[2]);
        }

        return $result;
    }
}
