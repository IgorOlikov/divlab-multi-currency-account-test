<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Balance;

interface BalanceRepositoryInterface
{
    public function save(Balance $account): void;
    public function findById(string $id): ?Balance;
}