<?php

namespace App\Domain\Repository;


use App\Domain\Entity\DomainAccount;

interface AccountRepositoryInterface
{
    public function save(DomainAccount $account): void;
    public function findById(string $id): ?DomainAccount;
}