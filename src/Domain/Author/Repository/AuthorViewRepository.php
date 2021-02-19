<?php

namespace App\Domain\Author\Repository;

use PDO;

/**
 * Repository.
 */
class AuthorViewRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function selectAllAuthor(): array
    {
        $sql = "SELECT * FROM auteurs";

        $query = $this->connection->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function selectAuthor($id): array
    {
        $params = [ "id" => $id];
        
        $sql = "SELECT * FROM auteurs WHERE id = :id";

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}

