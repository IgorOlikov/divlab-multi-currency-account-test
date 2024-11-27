<?php

namespace App\Application\Command\Client;

use App\Application\Command\CommandInterface;

readonly class RegisterClientCommand implements CommandInterface
{
    public function __construct(
        private string $name,
        private string $email,
        private string $password
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


}