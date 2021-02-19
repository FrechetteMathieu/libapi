<?php

namespace App\Domain\Author\Repository;

use PDO;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Repository.
 */
class AuthorCreateRepository
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
            ->addFileHandler('Author.log')
            ->createLogger("AuthorCreateRepository");
    }

    /**
     * Insert author
     *
     * @param array $author The book
     *
     * @return int The new author ID
     */
    public function insertAuthor(array $author): int
    {
        $params = [
            'nom' => $author['nom'] ?? '',
            'prenom' => $author['prenom'] ?? ''
        ];

        $sql = "INSERT INTO auteurs (nom, prenom) 
                VALUES (:nom, :prenom)";

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $errorInfo = $query->errorInfo();
        if($errorInfo[0] != 0) {
            $this->logger->error($errorInfo[2]);
        }

        return (int)$this->connection->lastInsertId();
    }
}

