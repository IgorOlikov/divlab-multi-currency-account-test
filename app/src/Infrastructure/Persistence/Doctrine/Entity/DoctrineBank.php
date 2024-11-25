<?php


namespace App\Infrastructure\Persistence\Doctrine\Entity;


use App\Infrastructure\Persistence\Doctrine\Repository\DoctrineBankRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: DoctrineBankRepository::class)]
#[ORM\Table(name: '`banks`')]
class DoctrineBank
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(name: 'name', type: Types::STRING, unique: true, nullable: false)]
    private ?string $name = null;


    #[ORM\OneToMany(targetEntity: DoctrineAccount::class, mappedBy: 'bank')]
    private ?Collection $accounts = null;

    #[ORM\ManyToMany(targetEntity: DoctrineCurrency::class, inversedBy: 'banks')]
    #[ORM\JoinTable(name: 'bank_currencies')]
    #[ORM\JoinColumn(name: 'bank_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'currency_id', referencedColumnName: 'id')]
    private ?Collection $currencies = null;

    #[ORM\OneToMany(targetEntity: DoctrineExchangeRate::class, mappedBy: 'bank')]
    private ?Collection $exchangeRates = null;

    public function __construct()
    {
        $this->accounts = new ArrayCollection();
        $this->currencies = new ArrayCollection();
        $this->exchangeRates = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAccounts(): ?Collection
    {
        return $this->accounts;
    }

    public function setAccounts(?Collection $accounts): void
    {
        $this->accounts = $accounts;
    }

    public function getCurrencies(): ?Collection
    {
        return $this->currencies;
    }

    public function addCurrency(DoctrineCurrency $currency): self
    {
        if (!$this->currencies->contains($currency)) {
            $this->currencies->add($currency);
            $currency->getBanks()->add($this);
        }

        return $this;
    }

    public function removeCurrency(DoctrineCurrency $currency): self
    {
        if ($this->currencies->removeElement($currency)) {
            $currency->getBanks()->removeElement($this);
        }

        return $this;
    }

    public function getExchangeRates(): ?Collection
    {
        return $this->exchangeRates;
    }

    public function addExchangeRate(DoctrineExchangeRate $exchangeRate): void
    {
        $this->exchangeRates->add($exchangeRate);
    }



}