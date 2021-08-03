<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Math;

use App\Service\Math\BcMathService;
use PHPUnit\Framework\TestCase;

class BcMathRoundServiceTest extends TestCase
{
    /**
     * @dataProvider roundDownDataProvider
     */
    public function testRoundDown(string $expected, string $value, int $scale): void
    {
        $service = new BcMathService($scale);
        self::assertSame($expected, $service->roundDown($value, $scale));
    }

    /**
     * @dataProvider roundUpDataProvider
     */
    public function testRoundUp(string $expected, string $value, int $scale): void
    {
        $service = new BcMathService($scale);
        self::assertSame($expected, $service->roundUp($value, $scale));
    }

    public function roundDownDataProvider(): array
    {
        return [
            ['5.00', '5.0', 2],
            ['5.00', '5.000', 2],
            ['5.00', '5.001', 2],
            ['0.00', '0.00001', 2],
            ['0.00', '0.001', 2],
            ['0.00', '0.0', 2],
            ['0.00', '0', 2],
            ['0', '0', 0],
            ['0', '0.1', 0],
            ['0', '0.001', 0],
            ['0', '0.000', 0],
        ];
    }

    public function roundUpDataProvider(): array
    {
        return [
            ['5.00', '5.0', 2],
            ['5.00', '5.000', 2],
            ['5.01', '5.001', 2],
            ['0.01', '0.00001', 2],
            ['0.01', '0.001', 2],
            ['0.00', '0.0', 2],
            ['0.00', '0', 2],
            ['0', '0', 0],
            ['1', '0.1', 0],
            ['1', '0.001', 0],
            ['0', '0.000', 0],
        ];
    }
}
