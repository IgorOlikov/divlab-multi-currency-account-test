<?php

namespace App\Infrastructure\Persistence\Doctrine\Entity;

use App\Infrastructure\Persistence\Doctrine\Repository\DoctrineCurrencyRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctrineCurrencyRepository::class)]
#[ORM\Table(name: '`currencies`')]
class DoctrineCurrency
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 3, unique: true, nullable: false)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: DoctrineBank::class, mappedBy: 'currencies')]
    private ?Collection $banks = null;

    #[ORM\ManyToMany(targetEntity: DoctrineAccount::class, mappedBy: 'accountCurrencies')]
    private ?Collection $accounts = null;

    #[ORM\OneToMany(targetEntity: DoctrineAccount::class, mappedBy: 'primeCurrency')]
    private ?Collection $accountsWithPrimeCurrency = null;

    #[ORM\OneToMany(targetEntity: DoctrineBalance::class, mappedBy: 'currency')]
    private ?Collection $balances = null;

    #[ORM\Column(name: 'updated_at', type: Types::DATE_IMMUTABLE, unique: false, nullable: true, options: ['default' => null])]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\Column(name: 'created_at', type: Types::DATE_IMMUTABLE, unique: false, nullable: false)]
    private ?DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->banks = new ArrayCollection();
        $this->accounts = new ArrayCollection();
        $this->accountsWithPrimeCurrency = new ArrayCollection();
        $this->balances = new ArrayCollection();
    }

    public function getAccounts(): ?Collection
    {
        return $this->accounts;
    }

    public function getAccountsWithPrimeCurrency(): ?Collection
    {
        return $this->accountsWithPrimeCurrency;
    }

    public function getBalances(): ?Collection
    {
        return $this->balances;
    }

    public function getBanks(): Collection
    {
        return $this->banks;
    }

    public function addBank(DoctrineBank $bank): self
    {
        if (!$this->banks->contains($bank)) {
            $this->banks->add($bank);
            $bank->getCurrencies()->add($this);
        }

        return $this;
    }

    public function removeBank(DoctrineBank $bank): self
    {
        if ($this->banks->removeElement($bank)) {
            $bank->getCurrencies()->removeElement($this);
        }

        return $this;
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