<?php

namespace App\UI\Request;

use Symfony\Component\Validator\Constraints as Assert;

class UserRequestDTO
{
    #[Assert\NotBlank(groups: ['register'])]
    #[Assert\Length(min: 8, max: 20, groups: ['register'])]
    public ?string $name = null;

    #[Assert\NotBlank(groups: ['register'])]
    #[Assert\Email(groups: ['register'])]
    #[Assert\Length(min: 5, max: 30, groups: ['register'])]
    public ?string $email = null;

    #[Assert\NotBlank(groups: ['register'])]
    #[Assert\Length(min: 8, max: 20, groups: ['register'])]
    public ?string $password = null;

    #[Assert\NotBlank(groups: ['register'])]
    #[Assert\IdenticalTo(propertyPath: 'password', groups: ['register'])]
    public ?string $passwordConfirmation = null;
}