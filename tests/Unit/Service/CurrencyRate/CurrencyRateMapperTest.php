<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\CurrencyRate;

use App\Service\CurrencyRate\CurrencyRateFetcherInterface;
use App\Service\CurrencyRate\CurrencyRateMapper;
use PHPUnit\Framework\TestCase;

class CurrencyRateMapperTest extends TestCase
{
    private const SAVED_RATES = [
        'EUR' => 1,
        'JPY' => 129.53,
        'USD' => 1.1497,
    ];

    /**
     * @dataProvider setCurrenciesRateSuccessDataProvider
     */
    public function testSetCurrenciesRateSuccess(array $rates): void
    {
        $service = $this->getCurrencyRateMapper($rates);

        foreach ($rates as $code => $value) {
            self::assertSame((string)self::SAVED_RATES[$code], $service->getRate($code));
        }
    }

    public function testSetCurrenciesRateFail(): void
    {
        $this->expectException('App\Exception\CurrencyRateMapperException');
        $service = $this->getCurrencyRateMapper(self::SAVED_RATES);
        $service->getRate('BAD');
    }

    private function getCurrencyRateMapper(array $rates): CurrencyRateMapper
    {
        $rateParser = $this->createMock(CurrencyRateFetcherInterface::class);
        $rateParser->method('fetchRates')->willReturn($rates);

        return new CurrencyRateMapper($rateParser);
    }

    public function setCurrenciesRateSuccessDataProvider(): array
    {
        return [
            [
                self::SAVED_RATES
            ],
            [
                [
                    'EUR' => 1,
                    'JPY' => 128.67,
                    'USD' => 1.1584,
                ]
            ],
            [
                [
                    'EUR' => 1,
                    'JPY' => 127.38,
                    'USD' => 1.1672,
                ]
            ],
        ];
    }
}
