<?php

namespace App\Domain\Repository;


use App\Domain\Entity\Client;

interface ClientRepositoryInterface
{
    public function saveAndReturn(Client $client): Client;

    public function findById(string $id): ?Client;

    public function existsByEmail(string $email): bool;

    public function existsByName(string $name): bool;

    public function save(Client $client): void;
}