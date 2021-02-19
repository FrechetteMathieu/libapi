<?php

namespace App\Domain\Author\Service;

use App\Domain\Author\Repository\AuthorUpdateRepository;
use App\Domain\Author\Repository\AuthorViewRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;
use App\Exception\ValidationException;
use App\Exception\RessourceNotFoundException;

/**
 * Service.
 */
final class AuthorUpdate
{
    /**
     * @var AuthorUpdateRepository
     */
    private $repository;

    /**
     * @var AuthorViewRepository
     */
    private $authorViewRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * The constructor.
     *
     * @param AuthorUpdateRepository $repository The repository
     */
    public function __construct(
        AuthorUpdateRepository $repository, 
        AuthorViewRepository $authorViewRepository,
        LoggerFactory $logger)
    {
        $this->repository = $repository;
        $this->authorViewRepository = $authorViewRepository;
        $this->logger = $logger
            ->addFileHandler('Author.log')
            ->createLogger("AuthorUpdate");
    }

    /**
     * Update an author
     *
     * @param int   $id     The id of the author to update
     * @param array $data   The author values to update
     *
     * @return array The author object updated
     */
    public function updateAuthor(int $id, array $data): array
    {
        $updateSucceed = false;
        // Validate if author exist
        $this->validateAuthor($id);
        // Validate if all fields are sent
        $this->validateAuthorData($data);

        // Update book
        $updateSucceed = $this->repository->updateAuthor($id, $data);

        $this->logger->info("L'auteur id [{$id}]" . ($updateSucceed ? " a été modifié" : " n'a pu être modifié"));

        return $data;
    }

    /**
     * Input validation.
     *
     * @param array $data The form data
     *
     * @throws RessourceNotFoundException
     *
     * @return void
     */
    private function validateAuthor(int $id): void
    {
        $author = $this->authorViewRepository->selectAuthor($id);

        if (empty($author)) {
            throw new RessourceNotFoundException("Aucun auteur trouvé pour le id {$id}");
        }
    }

    /**
     * Input validation.
     *
     * @param array $data The form data
     *
     * @throws ValidationException
     *
     * @return void
     */
    private function validateAuthorData(array $data): void
    {
        $errors = [];

        if(!isset($data['nom'])) {
            $errors['nom'] = 'Champs requis';
        }

        if(!isset($data['prenom'])) {
            $errors['prenom'] = 'Champs requis';
        }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }

}
