<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;


use App\Domain\Entity\DomainUser;
use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineUser;
use App\Infrastructure\Persistence\Doctrine\Mapper\DoctrineUserMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<DoctrineUser>
 */
class DoctrineUserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineUser::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof DoctrineUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function saveAndReturn(DomainUser $user): DomainUser
    {
        $doctrineUser = DoctrineUserMapper::toInfrastructure($user);

        $entityManager = $this->getEntityManager();

        $entityManager->persist($doctrineUser);

        $entityManager->flush();

        return DoctrineUserMapper::toDomain($doctrineUser);
    }

    public function findById(string $id): ?DomainUser
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

    public function save(DomainUser $user): void
    {
        $doctrineUser = DoctrineUserMapper::toInfrastructure($user);

        $entityManager = $this->getEntityManager();

        $entityManager->persist($doctrineUser);

        $entityManager->flush();
    }
}
