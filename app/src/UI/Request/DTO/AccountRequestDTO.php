<?php

namespace App\UI\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class AccountRequestDTO
{
    #[Assert\NotBlank()]
    #[Assert\Uuid()]
    public string $bankId;

    #[Assert\NotBlank()]
    #[Assert\Uuid()]
    public string $primeCurrencyId;

    #[Assert\NotBlank()]
    #[Assert\Type('array')]
    #[Assert\All(
        new Assert\Collection([
            'fields' => [
                'currencyId' => new Assert\Sequentially([
                    new Assert\NotBlank(),
                    new Assert\Uuid()
                ])
            ]
        ])
    )]
    public array $currencyIds;

    #[Assert\Callback]
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