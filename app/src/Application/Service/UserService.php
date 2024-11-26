<?php

namespace App\Application\Service;

use App\Domain\Entity\DomainUser;
use App\Domain\Repository\UserRepositoryInterface;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }

    public function userExists(DomainUser $user): bool
    {
        if($this->userRepository->existsByEmail($user->getEmail())) {
            return true;
        } elseif ($this->userRepository->existsByName($user->getName())) {
            return true;
        }

        return  false;
    }

    public function saveAndReturn(DomainUser $user): DomainUser
    {
        return $this->userRepository->saveAndReturn($user);
    }

}