<?php

namespace App\Infrastracture\Persistence\Doctrine\Repository;

use App\Domain\Repository\AccountRepositoryInterface;
use App\Domain\Entity\Account;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Account>
 */
class DoctrineAccountRepository extends ServiceEntityRepository implements AccountRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }


    #[\Override] public function save(Account $account): void
    {
        // TODO: Implement save() method.
    }

    #[\Override] public function findById(int $id): ?Account
    {
        // TODO: Implement findById() method.
    }
}
