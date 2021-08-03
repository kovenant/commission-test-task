<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\CurrencyConverter;

use App\DTO\Currency;
use App\Service\CurrencyConverter\CurrencyConverterService;
use App\Service\Math\BcMathService;
use PHPUnit\Framework\TestCase;

class CurrencyConverterServiceTest extends TestCase
{
    /**
     * @dataProvider covertDataProvider
     */
    public function testConvert(
        string $amount,
        Currency $fromCurrency,
        Currency $toCurrency,
        string $systemCurrencyCode,
        string $expected,
    ): void {
        $service = $this->getCurrencyConverterService($systemCurrencyCode);
        $this->assertSame($expected, $service->convert($amount, $fromCurrency, $toCurrency));
    }

    /**
     * @dataProvider covertToDefaultDataProvider
     */
    public function testConvertToDefault(
        string $amount,
        Currency $fromCurrency,
        string $expected,
    ): void {
        $service = $this->getCurrencyConverterService();
        $this->assertSame($expected, $service->convertToDefault($amount, $fromCurrency));
    }

    /**
     * @dataProvider covertFromDefaultDataProvider
     */
    public function testConvertFromDefault(
        string $amount,
        Currency $toCurrency,
        string $expected
    ): void {
        $service = $this->getCurrencyConverterService();
        $this->assertSame($expected, $service->convertFromDefault($amount, $toCurrency));
    }

    private function getCurrencyConverterService(string $systemCurrencyCode = 'EUR'): CurrencyConverterService
    {
        return new CurrencyConverterService($systemCurrencyCode, new BcMathService());
    }

    public function covertDataProvider(): array
    {
        return [
            [
                '100.00000000',
                new Currency('EUR', '1', 2),
                new Currency('EUR', '1', 2),
                'EUR',
                '100.00000000',
            ],
            [
                '100.00000000',
                new Currency('USD', '1', 2),
                new Currency('USD', '1', 2),
                'EUR',
                '100.00000000',
            ],
            [
                '100.00000000',
                new Currency('EUR', '1', 2),
                new Currency('USD', '1.1497', 2),
                'EUR',
                '114.97000000',
            ],
            [
                '100.00000000',
                new Currency('USD', '1.1497', 2),
                new Currency('EUR', '1', 2),
                'EUR',
                '86.97921196',
            ],
            [
                '100.00000000',
                new Currency('USD', '1.1497', 2),
                new Currency('JPY', '129.53', 0),
                'EUR',
                '11266.41732517',
            ],
            [
                '1000.00000000',
                new Currency('JPY', '129.53', 0),
                new Currency('USD', '1.1497', 2),
                'EUR',
                '8.87593607',
            ],
            [
                '100.00',
                new Currency('EUR', '1', 2),
                new Currency('USD', '1.1497', 2),
                'EUR',
                '114.97000000',
            ],
            [
                '100',
                new Currency('EUR', '1', 2),
                new Currency('USD', '1.1497', 2),
                'EUR',
                '114.97000000',
            ],
        ];
    }

    public function covertToDefaultDataProvider(): array
    {
        return [
            [
                '100.00000000',
                new Currency('USD', '1.1497', 2),
                '86.97921196',
            ],
            [
                '100.00000000',
                new Currency('USD', '1.1504', 2),
                '86.92628650',
            ],
            [
                '1000.00000000',
                new Currency('JPY', '129.53', 0),
                '7.72021925',
            ],
            [
                '1000.00000000',
                new Currency('JPY', '128.76', 0),
                '7.76638707',
            ],
        ];
    }

    public function covertFromDefaultDataProvider(): array
    {
        return [
            [
                '100.00000000',
                new Currency('USD', '1.1497', 2),
                '114.97000000',
            ],
            [
                '100.00000000',
                new Currency('USD', '1.1504', 2),
                '115.04000000',
            ],
            [
                '1000.00000000',
                new Currency('JPY', '129.53', 0),
                '129530.00000000',
            ],
            [
                '1000.00000000',
                new Currency('JPY', '128.76', 0),
                '128760.00000000',
            ],
        ];
    }
}
