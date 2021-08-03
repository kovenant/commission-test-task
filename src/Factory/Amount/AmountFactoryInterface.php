<?php

declare(strict_types=1);

namespace App\Factory\Amount;

use App\DTO\Amount;
use App\DTO\Currency;

interface AmountFactoryInterface
{
    public function build(string $value, Currency $currency): Amount;
}
