<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\DomainCurrency;
use App\Domain\Repository\CurrencyRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineCurrency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DoctrineCurrency>
 */
class DoctrineCurrencyRepository extends ServiceEntityRepository implements CurrencyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineCurrency::class);
    }


    #[\Override] public function save(DomainCurrency $account): void
    {
        // TODO: Implement save() method.
    }

    #[\Override] public function findById(string $id): ?DomainCurrency
    {
        // TODO: Implement findById() method.
    }
}
