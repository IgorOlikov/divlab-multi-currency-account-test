<?php

namespace App\Application\CommandHandler\User;

use App\Application\Command\CommandInterface;
use App\Application\Command\User\RegisterUserCommand;
use App\Application\CommandHandler\CommandHandlerInterface;
use App\Application\DTO\JwtTokensResult;
use App\Application\Exception\UserAlreadyExistsApplicationException;
use App\Application\Service\AuthService;
use App\Application\Service\UserService;
use App\Domain\Entity\DomainUser;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;

class RegisterUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserService $userService,
        private LoggerInterface $logger,
        private AuthService $authService,
        private NativePasswordHasher $nativePasswordHasher
    )
    {
    }

    /**
     * @param RegisterUserCommand $command
     * @return JwtTokensResult
     * @throws Exception
     */
    public function handle(CommandInterface $command): JwtTokensResult
    {
        $user = new DomainUser(
            name: $command->getName(),
            email: $command->getEmail(),
            password: $this->nativePasswordHasher->hash(($command->getPassword()))
        );


        if ($this->userService->userExists($user)) {
            throw new UserAlreadyExistsApplicationException('User with this email or name already exists.', 422);
        }

        try {
             $user = $this->userService->saveAndReturn($user);

             return $this->authService->authenticate($user);

        } catch (Exception $exception) {
            $this->logger->error("Authentication error: {$exception->getMessage()}", $exception->getTrace());
            throw $exception;
        }
    }
}