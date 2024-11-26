<?php

namespace App\Application\DTO;

use Symfony\Component\Serializer\Attribute\Groups;

class JwtTokensResult
{
    #[Groups(groups: ['public'])]
    private string $accessToken;

    #[Groups(groups: ['private'])]
    private  string $refreshToken;

    public function __construct(
        string $accessToken,
        string $refreshToken
    )
    {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }


    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }



}