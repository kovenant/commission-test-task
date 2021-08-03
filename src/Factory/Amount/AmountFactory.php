<?php

declare(strict_types=1);

namespace App\Factory\Amount;

use App\DTO\Amount;
use App\DTO\Currency;
use App\Exception\InvalidAmountValueException;

final class AmountFactory implements AmountFactoryInterface
{
    public function build(string $value, Currency $currency): Amount
    {
        if (!is_numeric($value)) {
            throw new InvalidAmountValueException($value);
        }

        return new Amount($value, $currency);
    }
}
