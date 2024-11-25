<?php

namespace App\Infrastructure\Persistence\Doctrine\Entity;


use App\Infrastructure\Persistence\Doctrine\Repository\DoctrineAccountRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: DoctrineAccountRepository::class)]
#[ORM\Table(name: '`accounts`')]
class DoctrineAccount
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    private ?DoctrineCurrency $currency = null;

    private ?DoctrineUser $user = null;


    public function getId(): ?Uuid
    {
        return $this->id;
    }
}
