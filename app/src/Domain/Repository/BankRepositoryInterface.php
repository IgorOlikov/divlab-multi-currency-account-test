<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Bank;

interface BankRepositoryInterface
{
    public function save(Bank $account): void;
    public function findById(int $id): ?Bank;
}