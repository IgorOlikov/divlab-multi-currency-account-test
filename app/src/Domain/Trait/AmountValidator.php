<?php

namespace App\Domain\Trait;

use App\Domain\Exception\AmountLessThanZeroDomainException;
use App\Domain\Exception\InvalidAmountDomainException;

trait AmountValidator
{
    public function validateAmount(string $amount): string
    {
        if (bccomp($amount, '0.00', 2) === -1) {
            throw new AmountLessThanZeroDomainException('Amount cannot be less than 0.00.', 422);
        }

        $validatedAmount = bcadd($amount, '0', 2);

        if ($validatedAmount !== $amount) {
            throw new InvalidAmountDomainException('Amount must be a valid number with up to 2 decimal places.', 422);
        }

        $digitsOnly = str_replace('.', '', $validatedAmount);
        if (strlen($digitsOnly) > 10) {
            throw new InvalidAmountDomainException('Amount must have no more than 10 significant digits.', 422);
        }

        return $amount;
    }

}