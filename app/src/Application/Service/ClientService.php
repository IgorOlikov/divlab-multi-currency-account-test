<?php

namespace App\Application\Service;

use App\Domain\Entity\Client;
use App\Domain\Repository\ClientRepositoryInterface;

class ClientService
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository
    )
    {}

    public function clientExists(Client $client): bool
    {
        if($this->clientRepository->existsByEmail($client->getEmail())) {
            return true;
        } elseif ($this->clientRepository->existsByName($client->getName())) {
            return true;
        }
        return  false;
    }

    public function saveAndReturn(Client $client): Client
    {
        return $this->clientRepository->saveAndReturn($client);
    }

}