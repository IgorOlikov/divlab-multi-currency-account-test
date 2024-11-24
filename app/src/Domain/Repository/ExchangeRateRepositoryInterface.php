<?php

namespace App\Domain\Repository;


use App\Domain\Entity\DomainExchangeRate;

interface ExchangeRateRepositoryInterface
{
    public function save(DomainExchangeRate $account): void;
    public function findById(string $id): ?DomainExchangeRate;
}