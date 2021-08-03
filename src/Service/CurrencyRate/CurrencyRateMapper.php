<?php

declare(strict_types=1);

namespace App\Service\CurrencyRate;

use App\Exception\CurrencyRateMapperException;

final class CurrencyRateMapper implements CurrencyRateMapperInterface
{
    private static array $rates = [];

    public function __construct(
        private CurrencyRateFetcherInterface $rateParser
    ) {
    }

    public function getRate(string $currencyCode): string
    {
        $rates = $this->getRates();

        try {
            $rate = (string)$rates[$currencyCode];
        } catch (\Exception $e) {
            throw new CurrencyRateMapperException(
                $currencyCode,
                'Currency rate does not exists',
                $e->getCode(),
                $e
            );
        }

        return $rate;
    }

    private function getRates(): array
    {
        if (empty(self::$rates)) {
            self::$rates = $this->rateParser->fetchRates();
        }

        return self::$rates;
    }
}
