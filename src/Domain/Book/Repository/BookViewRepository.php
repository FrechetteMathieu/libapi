<?php

namespace App\Domain\Book\Repository;

use PDO;

/**
 * Repository.
 */
class BookViewRepository
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
     * Sélectionne tous les livres
     */
    public function selectAllBook(): array
    {
        $sql = "SELECT * FROM livres";

        $query = $this->connection->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Sélectionne tous les livres de la page
     */
    public function selectAllBookWithPagination(int $noPage, int $nbLivreParPage): array
    {
        $offset = ($noPage - 1) * $nbLivreParPage;

        $sql = "SELECT * FROM livres LIMIT :nbRecord OFFSET :offset";

        $query = $this->connection->prepare($sql);
        $query->bindValue(':nbRecord', (int)$nbLivreParPage, PDO::PARAM_INT);
        $query->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Sélectionne un livre selon son id
     */
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

    /**
     * Sélectionne les livres d'un auteur
     */
    public function selectBookByAuthorId(int $authorId): array
    {
        $params = [
                    'auteurId' => $authorId,
                ];

        $sql = "select l.*
                from livres l 
                    inner join livreauteur la on la.livreId = l.id
                where la.auteurId = :auteurId";

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Afficher des livres selon un titre
     * 
     * @return array La liste des livres trouvés
     */
    public function selectBookByTitle(string $title): array
    {

        $sql = "SELECT * FROM livres 
                WHERE titre LIKE :titre";

        $query = $this->connection->prepare($sql);
        $query->bindValue(':titre', '%' . $title . '%');
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function countBooks(): int
    {
        $sql = "SELECT COUNT(*) AS nbTotal FROM livres";

        $query = $this->connection->prepare($sql);
        $query->execute();

        $nbBooks = $query->fetchAll(PDO::FETCH_ASSOC)[0]['nbTotal'] ?? 0;

        return $nbBooks;
    }
}

