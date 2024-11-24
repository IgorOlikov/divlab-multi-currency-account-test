<?php

namespace App\Domain\Repository;

use App\Domain\Entity\DoctrineBank;

interface BankRepositoryInterface
{
    public function save(DoctrineBank $account): void;
    public function findById(int $id): ?DoctrineBank;
}