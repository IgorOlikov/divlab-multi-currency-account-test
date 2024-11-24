<?php

namespace App\Domain\Repository;

use App\Domain\Entity\DoctrineBalance;

interface BalanceRepositoryInterface
{
    public function save(DoctrineBalance $account): void;
    public function findById(int $id): ?DoctrineBalance;
}