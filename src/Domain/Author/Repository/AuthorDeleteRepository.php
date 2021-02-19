<?php

namespace App\Domain\Author\Repository;

use PDO;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Repository.
 */
class AuthorDeleteRepository
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
            ->addFileHandler('Authors.log')
            ->createLogger('AuthorDeleteRepository');
    }

    /**
     * Delete an author by his id
     *
     * @param array $is The author id to delete
     *
     * @return bool Is the query succeed
     */
    public function deleteAuthor(int $id): bool
    {
        $params = ['id' => $id];

        // Delete author reference from joint table livreauteur
        $sqlLivreAuteur = "DELETE FROM livreauteur WHERE auteurId = :id";
        $query = $this->connection->prepare($sqlLivreAuteur);
        $result = $query->execute($params);

        if($result) {
            $sql = "DELETE FROM auteurs WHERE id = :id";

            $query = $this->connection->prepare($sql);
            $result = $query->execute($params);
        }   
        
        $errorInfo = $query->errorInfo();
        if($errorInfo[0] != 0) {
            $this->logger->error($errorInfo[2]);
        }

        return $result;
    }
}
