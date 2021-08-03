<?php

declare(strict_types=1);

namespace App\Service\CurrencyConverter;

use App\DTO\Currency;

interface CurrencyConverterServiceInterface
{
    public function convert(string $amount, Currency $fromCurrency, Currency $toCurrency): string;

    public function convertToDefault(string $amount, Currency $fromCurrency): string;

    public function convertFromDefault(string $amount, Currency $toCurrency): string;
}
