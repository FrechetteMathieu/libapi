<?php

namespace App\Domain\Book\Repository;

use PDO;

/**
 * Repository.
 */
class BookViewerRepository
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

    // /**
    //  * Insert user row.
    //  *
    //  * @param array $user The user
    //  *
    //  * @return int The new ID
    //  */
    // public function insertUser(array $user): int
    // {
    //     $row = [
    //         'username' => $user['username'],
    //         'first_name' => $user['first_name'],
    //         'last_name' => $user['last_name'],
    //         'email' => $user['email'],
    //     ];

    //     $sql = "INSERT INTO users SET 
    //             username=:username, 
    //             first_name=:first_name, 
    //             last_name=:last_name, 
    //             email=:email;";

    //     $this->connection->prepare($sql)->execute($row);

    //     return (int)$this->connection->lastInsertId();
    // }


    public function selectAllBook(): array
    {
        $sql = "SELECT * FROM livres";

        $query = $this->connection->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function selectBookById(int $id): array
    {
        $params = [
                    'id' => $id,
                ];


        $sql = "SELECT * FROM livres WHERE id = :id";

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}

