<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;


use App\Domain\Entity\DoctrineBalance;
use App\Domain\Repository\BalanceRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DoctrineBalance>
 */
class DoctrineBalanceRepository extends ServiceEntityRepository implements BalanceRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineBalance::class);
    }

    #[\Override] public function save(DoctrineBalance $account): void
    {
        // TODO: Implement save() method.
    }

    #[\Override] public function findById(int $id): ?DoctrineBalance
    {
        // TODO: Implement findById() method.
    }
}