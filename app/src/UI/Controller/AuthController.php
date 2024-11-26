<?php

namespace App\UI\Controller;

use App\Application\Command\User\RegisterUserCommand;

use App\Application\CommandHandler\User\RegisterUserCommandHandler;
use App\UI\Request\UserRequestDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;


#[Route(path: 'api/v1/auth')]
class AuthController extends AbstractController
{
    public function __construct(
        private readonly RegisterUserCommandHandler $registerUserCommandHandler
    )
    {}

    #[Route(path: '/register', methods: ['POST'])]
    public function register(
        #[MapRequestPayload(acceptFormat: 'json' , validationGroups: ['register'])]
        UserRequestDTO $userRequestDTO
    ): Response
    {
        $jwtTokenResult = $this->registerUserCommandHandler->handle(
            new RegisterUserCommand(
                name: $userRequestDTO->name,
                email: $userRequestDTO->email,
                password: $userRequestDTO->password
        ));

        $response = $this->json($jwtTokenResult, 201, context: [AbstractNormalizer::GROUPS => ['public']]);

        $response->headers->setCookie(Cookie::create('refresh_token', $jwtTokenResult->getRefreshToken(), (new \DateTime())->modify('+1 month')));

        return $response;
    }

}