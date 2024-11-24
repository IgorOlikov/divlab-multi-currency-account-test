<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\DoctrineExchangeRate;
use App\Domain\Repository\ExchangeRateRepositoryInterface;
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

    #[\Override] public function save(DoctrineExchangeRate $account): void
    {
        // TODO: Implement save() method.
    }

    #[\Override] public function findById(int $id): ?DoctrineExchangeRate
    {
        // TODO: Implement findById() method.
    }
}