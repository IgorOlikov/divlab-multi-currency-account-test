<?php

namespace App\Domain\Repository;

use App\Domain\Entity\DoctrineExchangeRate;

interface ExchangeRateRepositoryInterface
{
    public function save(DoctrineExchangeRate $account): void;
    public function findById(int $id): ?DoctrineExchangeRate;
}