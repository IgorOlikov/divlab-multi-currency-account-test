<?php

namespace App\Domain\Repository;


use App\Domain\Entity\Currency;

interface CurrencyRepositoryInterface
{
    public function save(Currency $account): void;
    public function findById(string $id): ?Currency;
}