<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\Bank;
use App\Domain\Repository\BankRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bank>
 */
class DoctrineBankRepository extends ServiceEntityRepository implements BankRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bank::class);
    }

    #[\Override] public function save(Bank $account): void
    {
        // TODO: Implement save() method.
    }

    #[\Override] public function findById(int $id): ?Bank
    {
        // TODO: Implement findById() method.
    }
}