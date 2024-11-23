<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\ExchangeRate;
use App\Domain\Repository\ExchangeRateRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExchangeRate>
 */
class DoctrineExchangeRateRepository extends ServiceEntityRepository implements ExchangeRateRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExchangeRate::class);
    }

    #[\Override] public function save(ExchangeRate $account): void
    {
        // TODO: Implement save() method.
    }

    #[\Override] public function findById(int $id): ?ExchangeRate
    {
        // TODO: Implement findById() method.
    }
}