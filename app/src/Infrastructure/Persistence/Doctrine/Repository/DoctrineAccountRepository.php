<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\Account;
use App\Domain\Repository\AccountRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DoctrineAccount>
 */
class DoctrineAccountRepository extends ServiceEntityRepository implements AccountRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineAccount::class);
    }


    #[\Override] public function save(Account $account): void
    {
        // TODO: Implement save() method.
    }

    #[\Override] public function findById(string $id): ?Account
    {
        // TODO: Implement findById() method.
    }
}
