<?php

namespace App\Domain\Entity;



class DomainUser
{

    private ?Uuid $id = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    #[\Override] public function getRoles(): array
    {
        // TODO: Implement getRoles() method.
    }

    #[\Override] public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    #[\Override] public function getUserIdentifier(): string
    {
        // TODO: Implement getUserIdentifier() method.
    }
}
