<?php

namespace App\Infrastracture\Persistence\Doctrine\Repository;

use App\Domain\Repository\AccountRepositoryInterface;
use App\Domain\Entity\DoctrineAccount;
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


    #[\Override] public function save(DoctrineAccount $account): void
    {
        // TODO: Implement save() method.
    }

    #[\Override] public function findById(int $id): ?DoctrineAccount
    {
        // TODO: Implement findById() method.
    }
}
