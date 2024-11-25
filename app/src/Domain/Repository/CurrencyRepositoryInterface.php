<?php

namespace App\Domain\Repository;


use App\Domain\Entity\DomainCurrency;

interface CurrencyRepositoryInterface
{
    public function save(DomainCurrency $account): void;
    public function findById(string $id): ?DomainCurrency;
}