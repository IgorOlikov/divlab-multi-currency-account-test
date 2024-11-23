<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;


use App\Domain\Entity\Balance;
use App\Domain\Repository\BalanceRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Balance>
 */
class DoctrineBalanceRepository extends ServiceEntityRepository implements BalanceRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Balance::class);
    }

    #[\Override] public function save(Balance $account): void
    {
        // TODO: Implement save() method.
    }

    #[\Override] public function findById(int $id): ?Balance
    {
        // TODO: Implement findById() method.
    }
}