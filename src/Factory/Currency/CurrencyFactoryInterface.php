<?php

declare(strict_types=1);

namespace App\Factory\Currency;

use App\DTO\Currency;

interface CurrencyFactoryInterface
{
    public function build(string $currencyCode): Currency;
}
