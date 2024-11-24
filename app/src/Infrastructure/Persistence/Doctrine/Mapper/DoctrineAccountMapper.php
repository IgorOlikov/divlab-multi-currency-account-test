<?php

namespace App\Infrastructure\Persistence\Doctrine\Mapper;

use App\Domain\Entity\DomainAccount;
use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineAccount;
use Money;

class DoctrineAccountMapper
{
    public static function toDomain(DoctrineAccount $doctrineAccount): DomainAccount
    {
        return new DomainAccount($doctrineAccount->getId(), new Money($entity->getBalance()));
    }

    public static function toInfrastructure(DomainAccount $account): DoctrineAccount
    {
        $entity = new DoctrineAccount();
        $entity->setId($account->getId());
        $entity->setBalance($account->getBalance()->getAmount());

        return $entity;
    }
}