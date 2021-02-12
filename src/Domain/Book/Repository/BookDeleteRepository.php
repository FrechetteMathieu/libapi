<?php

namespace App\Domain\Book\Repository;

use PDO;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Repository.
 */
class BookDeleteRepository
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
            ->createLogger();
    }

    /**
     * Delete a book by his id
     *
     * @param array $is The book id to delete
     *
     * @return bool Is the query succeed
     */
    public function deleteBook(int $id): bool
    {
        $params = ['id' => $id];
        $sql = "DELETE FROM livres WHERE id = :id";

        $query = $this->connection->prepare($sql);
        $result = $query->execute($params);

        $errorInfo = $query->errorInfo();
        if($errorInfo[0] != 0) {
            $this->logger->error($errorInfo[2]);
        }

        return $result;
    }
}
