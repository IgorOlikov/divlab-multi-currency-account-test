<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\DoctrineBank;
use App\Domain\Repository\BankRepositoryInterface;
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

    #[\Override] public function save(DoctrineBank $account): void
    {
        // TODO: Implement save() method.
    }

    #[\Override] public function findById(int $id): ?DoctrineBank
    {
        // TODO: Implement findById() method.
    }
}