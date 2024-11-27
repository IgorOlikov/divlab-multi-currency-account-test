<?php

namespace App\Application\CommandHandler\Client;

use App\Application\Command\CommandInterface;
use App\Application\Command\Client\RegisterClientCommand;
use App\Application\CommandHandler\CommandHandlerInterface;
use App\Application\DTO\JwtTokensResult;
use App\Application\Exception\UserAlreadyExistsApplicationException;
use App\Application\Service\AuthService;
use App\Application\Service\ClientService;
use App\Domain\Entity\Client;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;

class RegisterClientCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ClientService        $clientService,
        private LoggerInterface      $logger,
        private AuthService          $authService,
        private NativePasswordHasher $nativePasswordHasher
    )
    {
    }

    /**
     * @param RegisterClientCommand $command
     * @return JwtTokensResult
     * @throws Exception
     */
    public function handle(CommandInterface $command): JwtTokensResult
    {
        $client = new Client(
            name: $command->getName(),
            email: $command->getEmail(),
            password: $this->nativePasswordHasher->hash(($command->getPassword()))
        );


        if ($this->clientService->clientExists($client)) {
            throw new UserAlreadyExistsApplicationException('Client with this email or name already exists.', 422);
        }

        try {
            $client = $this->clientService->saveAndReturn($client);

            return $this->authService->authenticate($client);

        } catch (Exception $exception) {
            $this->logger->error("Authentication error: {$exception->getMessage()}", $exception->getTrace());
            throw $exception;
        }
    }
}