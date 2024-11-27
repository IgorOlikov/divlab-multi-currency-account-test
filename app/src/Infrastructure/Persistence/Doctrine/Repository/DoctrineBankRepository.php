<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;


use App\Domain\Entity\Bank;
use App\Domain\Repository\BankRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineBank;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DoctrineBank>
 */
class DoctrineBankRepository extends ServiceEntityRepository implements BankRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineBank::class);
    }

    #[\Override] public function save(Bank $account): void
    {
        // TODO: Implement save() method.
    }

    #[\Override] public function findById(string $id): ?Bank
    {
        // TODO: Implement findById() method.
    }
}