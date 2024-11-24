<?php

namespace App\Domain\Repository;

use App\Domain\Entity\DomainBalance;

interface BalanceRepositoryInterface
{
    public function save(DomainBalance $account): void;
    public function findById(string $id): ?DomainBalance;
}