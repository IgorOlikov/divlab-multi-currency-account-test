<?php

namespace App\UI\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class AccountRequestDTO
{
    #[Assert\NotBlank(groups: ['createAccount'])]
    #[Assert\Uuid(groups: ['createAccount'])]
    public string $bankId;

    #[Assert\NotBlank(groups: ['createAccount'])]
    #[Assert\Uuid(groups: ['createAccount'])]
    public string $primeCurrencyId;

    #[Assert\NotBlank(groups: ['createAccount'])]
    #[Assert\Type(type: 'array', groups: ['createAccount'])]
    #[Assert\All(
        constraints:
        new Assert\Collection([
            'fields' => [
                'currencyId' => new Assert\Sequentially([
                    new Assert\NotBlank(),
                    new Assert\Uuid()
                ])
            ]
        ]),
        groups: ['createAccount']
    )]
    public array $currencyIds;

    #[Assert\Callback(groups: ['createAccount'])]
    public function validatePrimeCurrencyIdInCurrencyIds(ExecutionContextInterface $context): void
    {
        $currencyIds = array_map(fn ($item) => $item['currencyId'], $this->currencyIds);

        if (!in_array($this->primeCurrencyId, $currencyIds, true)) {
            $context->buildViolation('The primeCurrencyId must be in the list of currencyIds.')
                ->atPath('primeCurrencyId')
                ->addViolation();
        }
    }

}