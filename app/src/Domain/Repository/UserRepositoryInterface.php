<?php

namespace App\Domain\Repository;


use App\Domain\Entity\DomainUser;

interface UserRepositoryInterface
{
    public function saveAndReturn(DomainUser $user): DomainUser;

    public function findById(string $id): ?DomainUser;

    public function existsByEmail(string $email): bool;

    public function existsByName(string $name): bool;

    public function save(DomainUser $user): void;
}