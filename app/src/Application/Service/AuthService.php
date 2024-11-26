<?php

namespace App\Application\Service;

use App\Application\DTO\JwtTokensResult;
use App\Domain\Entity\DomainUser;
use App\Infrastructure\Security\JwtTokenService;

class AuthService
{
    public function __construct(
        private JwtTokenService $jwtTokenService

    )
    {
    }

    public function authenticate(DomainUser $user): JwtTokensResult
    {
        return $this->jwtTokenService->authenticateUser($user);
    }
}