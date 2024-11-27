<?php

namespace App\UI\Controller;

use App\Application\Command\Client\RegisterClientCommand;

use App\Application\CommandHandler\Client\RegisterClientCommandHandler;
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
        private readonly RegisterClientCommandHandler $registerClientCommandHandler
    )
    {}

    #[Route(path: '/register', methods: ['POST'])]
    public function register(
        #[MapRequestPayload(acceptFormat: 'json' , validationGroups: ['register'])]
        UserRequestDTO $clientRequestDTO
    ): Response
    {
        $jwtTokenResult = $this->registerClientCommandHandler->handle(
            new RegisterClientCommand(
                name: $clientRequestDTO->name,
                email: $clientRequestDTO->email,
                password: $clientRequestDTO->password
        ));

        $response = $this->json($jwtTokenResult, 201, context: [AbstractNormalizer::GROUPS => ['public']]);

        $response->headers->setCookie(Cookie::create('refresh_token', $jwtTokenResult->getRefreshToken(), (new \DateTime())->modify('+1 month')));

        return $response;
    }

}