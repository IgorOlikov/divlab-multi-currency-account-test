<?php

namespace App\UI\Controller;

use App\UI\Request\AccountRequestDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class AccountController extends AbstractController
{
    public function __construct(

    ){}

    #[Route('api/create-account', methods: ['POST'])]
    public function createAccount(
        #[MapRequestPayload(
            acceptFormat: 'json',
            validationGroups: ['createAccount']
        )] AccountRequestDTO $accountRequestDTO
    )
    {

    }

}