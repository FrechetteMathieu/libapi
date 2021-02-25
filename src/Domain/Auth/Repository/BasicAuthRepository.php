<?php

namespace App\Domain\Auth\Repository;

use PDO;

/**
 * Repository.
 */
class BasicAuthRepository
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

    /**
     * Select username hashed password
     * 
     * @param string $username The username to select
     *
     * @return bool true if the token is valid
     */
    public function selectHashedPassword($username): string
    {
        $params = ["username" => $username];

        $sql = "SELECT `password` FROM users WHERE username = :username";

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $hashedPassword = $result[0]['password'] ?? ''; 

        return $hashedPassword;
    }
}

