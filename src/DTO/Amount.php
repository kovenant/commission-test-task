<?php

declare(strict_types=1);

namespace App\DTO;

final class Amount
{
    public function __construct(
        private string $value,
        private Currency $currency,
    ) {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}
