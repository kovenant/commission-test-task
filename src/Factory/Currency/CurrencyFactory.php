<?php

declare(strict_types=1);

namespace App\Factory\Currency;

use App\DTO\Currency;
use App\Exception\InvalidCurrencyException;
use App\Service\CurrencyRate\CurrencyRateMapperInterface;

final class CurrencyFactory implements CurrencyFactoryInterface
{
    /**
     * @param array<string,int> $availableCurrencies
     * @param CurrencyRateMapperInterface $currencyRateMapper
     */
    public function __construct(
        private array $availableCurrencies,
        private CurrencyRateMapperInterface $currencyRateMapper
    ) {
    }

    public function build(string $currencyCode): Currency
    {
        $currencies = $this->availableCurrencies;

        if (!array_key_exists($currencyCode, $currencies)) {
            throw new InvalidCurrencyException($currencyCode, 'Invalid currency code');
        }

        $rate = $this->currencyRateMapper->getRate($currencyCode);

        $scale = $currencies[$currencyCode];

        return new Currency($currencyCode, $rate, $scale);
    }
}
