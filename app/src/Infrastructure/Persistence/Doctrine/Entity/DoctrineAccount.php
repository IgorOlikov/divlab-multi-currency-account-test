<?php

namespace App\Infrastructure\Persistence\Doctrine\Entity;


use App\Infrastructure\Persistence\Doctrine\Repository\DoctrineAccountRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\OneToOne(targetEntity: DoctrineCurrency::class)]
    #[ORM\JoinColumn(name: 'prime_currency_id', referencedColumnName: 'id', unique: false, nullable: false)]
    private ?DoctrineCurrency $primeCurrency = null;

    #[ORM\ManyToOne(targetEntity: DoctrineUser::class, inversedBy: 'accounts')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', unique: false, nullable: false, onDelete: 'CASCADE')]
    private ?DoctrineUser $user = null;

    #[ORM\ManyToOne(targetEntity: DoctrineBank::class, inversedBy: 'accounts')]
    #[ORM\JoinColumn(name: 'bank_id', referencedColumnName: 'id', unique: false, nullable: false)]
    private ?DoctrineBank $bank = null;

    #[ORM\ManyToMany(targetEntity: DoctrineCurrency::class)]
    #[ORM\JoinTable(name: 'account_currencies')]
    #[ORM\JoinColumn(name: 'account_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'currency_id', referencedColumnName: 'id')]
    private ?Collection $accountCurrencies = null;

    #[ORM\OneToMany(targetEntity: DoctrineBalance::class, mappedBy: 'account', cascade: ['persist', 'remove'])]
    private ?Collection $accountBalances = null;

    #[ORM\Column(name: 'created_at', type: Types::DATE_IMMUTABLE, unique: false, nullable: false)]
    private ?DateTimeImmutable $createdAt = null;


    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->accountCurrencies = new ArrayCollection();
        $this->accountBalances = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getPrimeCurrency(): ?DoctrineCurrency
    {
        return $this->primeCurrency;
    }

    public function setPrimeCurrency(?DoctrineCurrency $primeCurrency): void
    {
        $this->primeCurrency = $primeCurrency;
    }

    public function getBank(): ?DoctrineBank
    {
        return $this->bank;
    }

    public function setBank(?DoctrineBank $bank): void
    {
        $this->bank = $bank;
    }

    public function getUser(): DoctrineUser
    {
        return $this->user;
    }

    public function setUser(?DoctrineUser $user): void
    {
        $this->user = $user;
    }

    public function getAccountCurrencies(): ?Collection
    {
        return $this->accountCurrencies;
    }

    public function addAccountCurrency(DoctrineCurrency $currency): void
    {
        $this->accountCurrencies->add($currency);
    }

    public function getAccountBalances(): ?Collection
    {
        return $this->accountBalances;
    }

    public function addAccountBalance(DoctrineBalance $balance): void
    {
        $this->accountBalances->add($balance);
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
