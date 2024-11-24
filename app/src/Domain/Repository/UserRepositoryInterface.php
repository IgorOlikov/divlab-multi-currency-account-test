<?php

namespace App\Domain\Repository;


use App\Domain\Entity\DomainUser;

interface UserRepositoryInterface
{
    public function save(DomainUser $account): void;
    public function findById(string $id): ?DomainUser;
}