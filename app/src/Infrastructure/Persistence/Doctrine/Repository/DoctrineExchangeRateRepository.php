<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\ExchangeRate;
use App\Domain\Repository\ExchangeRateRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineExchangeRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DoctrineExchangeRate>
 */
class DoctrineExchangeRateRepository extends ServiceEntityRepository implements ExchangeRateRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineExchangeRate::class);
    }

    #[\Override] public function save(ExchangeRate $account): void
    {
        // TODO: Implement save() method.
    }

    #[\Override] public function findById(string $id): ?ExchangeRate
    {
        // TODO: Implement findById() method.
    }
}