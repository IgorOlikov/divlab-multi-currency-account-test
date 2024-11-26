<?php

namespace App\Infrastructure\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class JwtTokenService
{
    private JWTTokenManagerInterface $jwtManager;
    private Security $security;

    public function __construct(JWTTokenManagerInterface $jwtManager, Security $security)
    {
        $this->jwtManager = $jwtManager;
        $this->security = $security;
    }


    /**
     * @throws JWTDecodeFailureException
     */
    public function getUserIdFromToken(): string
    {
        $token = $this->security->getToken();
        if (!$token) {
            throw new \RuntimeException('No token found');
        }

        $user = $this->jwtManager->decode($token);
        if (!$user || !isset($user['id'])) {
            throw new \RuntimeException('Invalid or expired token');
        }

        return (string) $user['id'];
    }

    public function validate()
    {
        //
    }
}