<?php

namespace App\Infrastructure\Persistence\Doctrine\Mapper;

use App\Domain\Entity\Client;
use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineClient;

class DoctrineClientMapper
{
    public static function toDomain(DoctrineClient $doctrineUser): Client
    {
        return new Client(
            name: $doctrineUser->getName(),
            email: $doctrineUser->getEmail(),
            password: $doctrineUser->getPassword(),
            id: $doctrineUser->getId(),
            roles: $doctrineUser->getRoles()
        );
    }

    public static function toInfrastructure(Client $domainUser): DoctrineClient
    {
        $doctrineUser = new DoctrineClient();
        $doctrineUser->setId($domainUser->getId());
        $doctrineUser->setRoles($domainUser->getRoles());
        $doctrineUser->setName($domainUser->getName());
        $doctrineUser->setEmail($domainUser->getEmail());
        $doctrineUser->setPassword($domainUser->getPassword());

        return $doctrineUser;
    }
}