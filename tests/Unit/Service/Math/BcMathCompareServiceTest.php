<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Math;

use App\Service\Math\BcMathService;
use PHPUnit\Framework\TestCase;

class BcMathCompareServiceTest extends TestCase
{
    /**
     * @dataProvider rightBiggerDataProvider
     */
    public function testIsRightBigger(string $left, string $right, int $scale): void
    {
        $service = new BcMathService($scale);
        $this->assertTrue($service->isRightBigger($left, $right));
    }

    /**
     * @dataProvider leftBiggerDataProvider
     */
    public function testIsLeftBigger(string $left, string $right, int $scale): void
    {
        $service = new BcMathService($scale);
        $this->assertTrue($service->isLeftBigger($left, $right));
    }

    /**
     * @dataProvider equalDataProvider
     */
    public function testIsEqual(string $left, string $right, int $scale): void
    {
        $service = new BcMathService($scale);
        $this->assertTrue($service->isEqual($left, $right));
    }

    /**
     * @dataProvider getMinDataProvider
     */
    public function testGetMin(string $left, string $right, int $scale, string $expected): void
    {
        $service = new BcMathService($scale);
        $this->assertSame($expected, $service->getMin($left, $right));
    }

    /**
     * @dataProvider getMaxDataProvider
     */
    public function testGetMax(string $left, string $right, int $scale, string $expected): void
    {
        $service = new BcMathService($scale);
        $this->assertSame($expected, $service->getMax($left, $right));
    }

    public function rightBiggerDataProvider(): array
    {
        return [
            ['1', '2', 8],
            ['0', '1', 8],
            ['1.01', '1.1', 8],
            ['0.00000001', '0.00000002', 8],
        ];
    }

    public function leftBiggerDataProvider(): array
    {
        return [
            ['2', '1', 8],
            ['1', '0', 8],
            ['1.1', '1.01', 8],
            ['0.00000002', '0.00000001', 8],
        ];
    }

    public function equalDataProvider(): array
    {
        return [
            ['1', '1', 8],
            ['0', '0', 8],
            ['1.01', '1.01', 8],
            ['0.00000002', '0.00000002', 8],
            ['0.00000002', '0.00000001', 7],
            ['0.00', '0.000000001', 2],
            ['0.00', '0.001', 2],
            ['0', '0.00', 2],
        ];
    }

    public function getMinDataProvider(): array
    {
        return [
            ['2', '1', 8, '1'],
            ['1', '0', 8, '0'],
            ['1.1', '1.01', 8, '1.01'],
            ['5', '5', 8, '5'],
            ['0.00000002', '0.00000001', 8, '0.00000001'],
            ['0.00000002', '0.00000001', 7, '0.00000002'],
        ];
    }

    public function getMaxDataProvider(): array
    {
        return [
            ['2', '1', 8, '2'],
            ['1', '0', 8, '1'],
            ['1.1', '1.01', 8, '1.1'],
            ['5', '5', 8, '5'],
            ['0.00000002', '0.00000001', 8, '0.00000002'],
            ['0.00000002', '0.00000001', 7, '0.00000001'],
        ];
    }
}
