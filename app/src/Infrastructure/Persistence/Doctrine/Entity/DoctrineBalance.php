<?php

namespace App\Infrastructure\Persistence\Doctrine\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Infrastructure\Persistence\Doctrine\Repository\DoctrineBalanceRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: DoctrineBalanceRepository::class)]
#[ORM\Table(name: '`balances`', options: ['check' => 'exchange_rate >= 0.00'])]
class DoctrineBalance
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(targetEntity: DoctrineAccount::class, inversedBy: 'accountBalances')]
    #[ORM\JoinColumn(name: 'account_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?DoctrineAccount $account = null;

    #[ORM\OneToOne(targetEntity: DoctrineCurrency::class)]
    #[ORM\JoinColumn(name: 'currency_id', referencedColumnName: 'id', nullable: false)]
    private ?DoctrineCurrency $currency = null;

    #[ORM\Column(name: 'amount', type: Types::DECIMAL, precision: 10, scale: 2, nullable: false, options: ['default' => '0.00'])]
    private string $amount = '0.00';

    #[ORM\Column(name: 'updated_at', type: Types::DATE_IMMUTABLE, unique: false, nullable: true, options: ['default' => null])]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\Column(name: 'created_at', type: Types::DATE_IMMUTABLE, unique: false, nullable: false)]
    private ?DateTimeImmutable $createdAt = null;


    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }


}