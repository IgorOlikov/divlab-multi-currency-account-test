<?php

namespace App\Infrastructure\Persistence\Doctrine\Entity;

use App\Infrastructure\Persistence\Doctrine\Repository\DoctrineBankRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: DoctrineBankRepository::class)]
#[ORM\Table(name: '`exchange_rates`', options: ['check' => 'exchange_rate >= 0.00'])]
class DoctrineExchangeRate
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;


    #[ORM\ManyToOne(targetEntity: DoctrineBank::class, inversedBy: 'exchangeRates')]
    #[ORM\Column(name: 'bank_id', type: Types::STRING, unique: false, nullable: false)]
    private ?DoctrineBank $bank = null;

    #[ORM\OneToOne(targetEntity: DoctrineCurrency::class)]
    #[ORM\JoinColumn(name: 'from_currency_id', referencedColumnName: 'id', nullable: false)]
    private ?DoctrineCurrency $fromCurrency = null;

    #[ORM\OneToOne(targetEntity: DoctrineCurrency::class)]
    #[ORM\JoinColumn(name: 'to_currency_id', referencedColumnName: 'id', nullable: false)]
    private ?DoctrineCurrency $toCurrency = null;

    #[ORM\Column(name: 'exchange_rate', type: Types::DECIMAL, precision: 10, scale: 2, nullable: false)]
    private ?string $exchangeRate = null;

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

    public function getBank(): ?DoctrineBank
    {
        return $this->bank;
    }

    public function setBank(?DoctrineBank $bank): void
    {
        $this->bank = $bank;
    }

    public function getFromCurrency(): ?DoctrineCurrency
    {
        return $this->fromCurrency;
    }

    public function setFromCurrency(?DoctrineCurrency $fromCurrency): void
    {
        $this->fromCurrency = $fromCurrency;
    }

    public function getToCurrency(): ?DoctrineCurrency
    {
        return $this->toCurrency;
    }

    public function setToCurrency(?DoctrineCurrency $toCurrency): void
    {
        $this->toCurrency = $toCurrency;
    }

    public function getExchangeRate(): ?string
    {
        return $this->exchangeRate;
    }

    public function setExchangeRate(string $exchangeRate): void
    {
        $this->exchangeRate = $exchangeRate;
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