<?php

namespace App\Application\Service;

use App\Application\DTO\JwtTokensResult;
use App\Domain\Entity\Client;
use App\Infrastructure\Security\JwtTokenService;

class AuthService
{
    public function __construct(
        private JwtTokenService $jwtTokenService

    )
    {
    }

    public function authenticate(Client $user): JwtTokensResult
    {
        return $this->jwtTokenService->authenticateUser($user);
    }
}