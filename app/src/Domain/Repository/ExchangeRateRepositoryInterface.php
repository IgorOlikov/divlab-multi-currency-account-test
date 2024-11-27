<?php

namespace App\Domain\Repository;


use App\Domain\Entity\ExchangeRate;

interface ExchangeRateRepositoryInterface
{
    public function save(ExchangeRate $account): void;
    public function findById(string $id): ?ExchangeRate;
}