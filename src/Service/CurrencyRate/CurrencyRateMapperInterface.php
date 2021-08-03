<?php

declare(strict_types=1);

namespace App\Service\CurrencyRate;

interface CurrencyRateMapperInterface
{
    public function getRate(string $currencyCode): string;
}
