<?php

namespace App\Domain\Book\Repository;

use PDO;

/**
 * Repository.
 */
class BookSearcherRepository
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
     * Recherche un livre selon un mot clé
     * 
     * @return array La liste des livres trouvés
     */
    public function searchBookByTitle(array $data): array
    {
        $titre = $data['titre'];

        $sql = "SELECT * FROM livres 
                WHERE titre LIKE :titre";

        $query = $this->connection->prepare($sql);
        $query->bindValue(':titre', '%' . $titre . '%');
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}

