<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;


use App\Domain\Entity\DomainBank;
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

    #[\Override] public function save(DomainBank $account): void
    {
        // TODO: Implement save() method.
    }

    #[\Override] public function findById(string $id): ?DomainBank
    {
        // TODO: Implement findById() method.
    }
}