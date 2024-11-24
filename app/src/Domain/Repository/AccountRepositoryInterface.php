<?php

namespace App\Domain\Repository;

use App\Domain\Entity\DoctrineAccount;

interface AccountRepositoryInterface
{
    public function save(DoctrineAccount $account): void;
    public function findById(int $id): ?DoctrineAccount;
}