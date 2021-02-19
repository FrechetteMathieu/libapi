<?php

namespace App\Domain\Author\Repository;

use PDO;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Repository.
 */
class AuthorUpdateRepository
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
            ->createLogger("BookUpdateRepository");
    }

    /**
     * Update an author
     *
     * @param array $is The author id to update
     *
     * @return bool Is the query succeed
     */
    public function updateAuthor(int $id, array $author): bool
    {

        $params = [
            'id' => $id,
            'nom' => $author['nom'],
            'prenom' => $author['prenom'],
        ];

        $sql = "UPDATE auteurs SET 
                nom=:nom, 
                prenom=:prenom
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
