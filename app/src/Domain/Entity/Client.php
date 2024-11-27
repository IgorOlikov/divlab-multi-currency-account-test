<?php

namespace App\Domain\Entity;

class Client
{
    private ?string $id;

    private string $name;

    private string $email;

    private string $password;

    private array $roles;

    /* @var Account[] $accounts */
    private array $accounts;

    public function __construct(
        string $name,
        string $email,
        string $password,
        ?string $id = null,
        array $roles = [],
        array $accounts = []
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
        $this->accounts = $accounts;
    }


    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return array|Account[]
     */
    public function getAccounts(): array
    {
        return $this->accounts;
    }

    /**
     * @param Account[] $accounts
     */
    public function setAccounts(array $accounts): void
    {
        $this->accounts = $accounts;
    }

}
