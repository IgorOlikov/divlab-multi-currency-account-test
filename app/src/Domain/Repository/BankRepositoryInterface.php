<?php

namespace App\Domain\Repository;


use App\Domain\Entity\DomainBank;

interface BankRepositoryInterface
{
    public function save(DomainBank $account): void;
    public function findById(string $id): ?DomainBank;
}