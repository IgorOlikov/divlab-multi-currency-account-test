<?php

namespace App\Infrastructure\Persistence\Doctrine\Mapper;

use App\Domain\Entity\DomainUser;
use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineUser;

class DoctrineUserMapper
{
    public static function toDomain(DoctrineUser $doctrineUser): DomainUser
    {
        return new DomainUser(
            name: $doctrineUser->getName(),
            email: $doctrineUser->getEmail(),
            password: $doctrineUser->getPassword(),
            roles: $doctrineUser->getRoles(),
            id: $doctrineUser->getId()
        );
    }

    public static function toInfrastructure(DomainUser $domainUser): DoctrineUser
    {
        $doctrineUser = new DoctrineUser();
        $doctrineUser->setId($domainUser->getId());
        $doctrineUser->setRoles($domainUser->getRoles());
        $doctrineUser->setName($domainUser->getName());
        $doctrineUser->setEmail($domainUser->getEmail());
        $doctrineUser->setPassword($domainUser->getPassword());

        return $doctrineUser;
    }
}