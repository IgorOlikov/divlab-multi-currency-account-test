<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Account;

interface AccountRepositoryInterface
{
    public function save(Account $account): void;
    public function findById(int $id): ?Account;
}