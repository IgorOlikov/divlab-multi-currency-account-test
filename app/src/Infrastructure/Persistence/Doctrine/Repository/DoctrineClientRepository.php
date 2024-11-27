<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;


use App\Domain\Entity\Client;
use App\Domain\Repository\ClientRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineClient;
use App\Infrastructure\Persistence\Doctrine\Mapper\DoctrineClientMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<DoctrineClient>
 */
class DoctrineClientRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, ClientRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineClient::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $client, string $newHashedPassword): void
    {
        if (!$client instanceof DoctrineClient) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $client::class));
        }

        $client->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($client);
        $this->getEntityManager()->flush();
    }

    public function saveAndReturn(Client $client): Client
    {
        $doctrineClient = DoctrineClientMapper::toInfrastructure($client);

        $entityManager = $this->getEntityManager();

        $entityManager->persist($doctrineClient);

        $entityManager->flush();

        return DoctrineClientMapper::toDomain($doctrineClient);
    }

    public function findById(string $id): ?Client
    {
        // TODO: Implement findById() method.
    }

    public function existsByEmail(string $email): bool
    {
        return $this->createQueryBuilder('u')
                ->select('COUNT(u.id)')
                ->where('u.email = :email')
                ->setParameter('email', $email)
                ->getQuery()
                ->getSingleScalarResult() > 0;
    }

    public function existsByName(string $name): bool
    {
        return $this->createQueryBuilder('u')
                ->select('COUNT(u.id)')
                ->where('u.name = :name')
                ->setParameter('name', $name)
                ->getQuery()
                ->getSingleScalarResult() > 0;
    }

    public function save(Client $client): void
    {
        $doctrineClient = DoctrineClientMapper::toInfrastructure($client);

        $entityManager = $this->getEntityManager();

        $entityManager->persist($doctrineClient);

        $entityManager->flush();
    }
}
