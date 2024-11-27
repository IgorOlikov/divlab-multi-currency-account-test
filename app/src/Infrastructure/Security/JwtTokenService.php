<?php

namespace App\Infrastructure\Security;

use App\Application\DTO\JwtTokensResult;
use App\Domain\Entity\Client;
use App\Infrastructure\Persistence\Doctrine\Mapper\DoctrineClientMapper;
use Gesdinet\JWTRefreshTokenBundle\Generator\RefreshTokenGeneratorInterface;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class JwtTokenService
{
    public function __construct(
        private JWTTokenManagerInterface $jwtManager,
        private RefreshTokenGeneratorInterface $refreshTokenGenerator,
        private Security $security,
        private RefreshTokenManagerInterface $refreshTokenManager
    )
    {
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

    public function authenticateUser(Client $domainUser): JwtTokensResult
    {
        $doctrineUser = DoctrineClientMapper::toInfrastructure($domainUser);

        $refreshToken = $this->refreshTokenGenerator->createForUserWithTtl($doctrineUser, 2592000);

        $this->refreshTokenManager->save($refreshToken);

        $accessToken = $this->jwtManager->create($doctrineUser);

        return new JwtTokensResult($accessToken, (string) $refreshToken);
    }
}