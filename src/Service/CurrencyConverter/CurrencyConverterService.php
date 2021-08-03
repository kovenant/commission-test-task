<?php

declare(strict_types=1);

namespace App\Service\CurrencyConverter;

use App\DTO\Currency;
use App\Service\Math\MathServiceInterface;

final class CurrencyConverterService implements CurrencyConverterServiceInterface
{
    public function __construct(
        private string $systemCurrencyCode,
        private MathServiceInterface $mathService,
    ) {
    }

    public function convert(string $amount, Currency $fromCurrency, Currency $toCurrency): string
    {
        if ($fromCurrency->getCode() !== $this->systemCurrencyCode) {
            $amount = $this->convertToDefault($amount, $fromCurrency);
        }

        if ($toCurrency->getCode() !== $this->systemCurrencyCode) {
            $amount = $this->convertFromDefault($amount, $toCurrency);
        }

        return $amount;
    }

    public function convertToDefault(string $amount, Currency $fromCurrency): string
    {
        return $this->mathService->div($amount, $fromCurrency->getRate());
    }

    public function convertFromDefault(string $amount, Currency $toCurrency): string
    {
        return $this->mathService->mul($amount, $toCurrency->getRate());
    }
}
