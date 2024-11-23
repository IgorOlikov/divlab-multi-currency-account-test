<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Bank;

interface UserRepositoryInterface
{
    public function save(Bank $account): void;
    public function findById(int $id): ?Bank;
}