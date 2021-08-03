<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Math;

use App\Service\Math\BcMathService;
use PHPUnit\Framework\TestCase;

class BcMathServiceTest extends TestCase
{
    private BcMathService $math;

    public function setUp(): void
    {
        $this->math = new BcMathService(2);
    }

    /**
     * @dataProvider dataProviderForAddTesting
     */
    public function testAdd(string $leftOperand, string $rightOperand, string $expectation): void
    {
        $this->assertEquals(
            $expectation,
            $this->math->add($leftOperand, $rightOperand)
        );
    }

    /**
     * @dataProvider dataProviderForSubTesting
     */
    public function testSub(string $leftOperand, string $rightOperand, string $expectation): void
    {
        $this->assertEquals(
            $expectation,
            $this->math->sub($leftOperand, $rightOperand)
        );
    }

    /**
     * @dataProvider dataProviderForMulTesting
     */
    public function testMul(string $leftOperand, string $rightOperand, string $expectation): void
    {
        $this->assertEquals(
            $expectation,
            $this->math->mul($leftOperand, $rightOperand)
        );
    }

    /**
     * @dataProvider dataProviderForDivTesting
     */
    public function testDiv(string $leftOperand, string $rightOperand, string $expectation): void
    {
        $this->assertEquals(
            $expectation,
            $this->math->div($leftOperand, $rightOperand)
        );
    }

    /**
     * @dataProvider dataProviderForPercentTesting
     */
    public function testPercent(string $fromValue, string $percent, string $expectation): void
    {
        $this->assertEquals(
            $expectation,
            $this->math->percent($fromValue, $percent)
        );
    }

    public function dataProviderForAddTesting(): array
    {
        return [
            'add 2 natural numbers' => ['1', '2', '3.00'],
            'add negative number to a positive' => ['-1', '2', '1.00'],
            'add natural number to a float' => ['1', '1.05123', '2.05'],
            'add negative number to a float' => ['-1', '1.05123', '0.05'],
            'add negative number to a negative float' => ['-1', '-1.05123', '-2.05'],
            'add positive number to zero' => ['0', '10', '10.00'],
            'add negative number to zero' => ['0', '-10', '-10.00'],
        ];
    }

    public function dataProviderForSubTesting(): array
    {
        return [
            'sub positive number from positive' => ['5', '2', '3.00'],
            'sub positive number from negative' => ['-1', '2', '-3.00'],
            'sub negative number from positive' => ['4', '-2', '6.00'],
            'sub negative number from negative' => ['-4', '-2', '-2.00'],
            'sub float number from positive' => ['2', '1.05123', '0.94'],
            'sub float negative number from positive' => ['2', '-1.05123', '3.05'],
            'sub positive number from zero' => ['0', '10', '-10.00'],
            'sub negative number from zero' => ['0', '-10', '10.00'],
            'sub zero from positive number' => ['10', '0', '10.00'],
            'sub zero from negative number' => ['-10', '0', '-10.00'],
        ];
    }

    public function dataProviderForMulTesting(): array
    {
        return [
            ['5', '2', '10.00'],
            ['-5', '2', '-10.00'],
            ['2', '1.05123', '2.10'],
            ['2', '-1.05123', '-2.10'],
            ['0', '10', '0.00'],
            ['0.5', '10', '5.00'],
            ['0.05', '10', '0.50'],
            ['0.005', '10', '0.05'],
            ['0.0005', '10', '0.00'],
        ];
    }

    public function dataProviderForDivTesting(): array
    {
        return [
            ['6', '2', '3.00'],
            ['2', '4', '0.50'],
            ['2', '6', '0.33'],
            ['2', '-4', '-0.50'],
            ['-6', '3', '-2.00'],
            ['6.666', '3', '2.22'],
            ['8', '2.5', '3.20'],
            ['8', '2.555', '3.13'],
            ['10', '0.5', '20.00'],
            ['0.5', '10', '0.05'],
            ['0.5', '10', '0.05'],
            ['0.05', '10', '0.00'],
        ];
    }

    public function dataProviderForPercentTesting(): array
    {
        return [
            ['100', '2', '2.00'],
            ['100', '0', '0.00'],
            ['100', '0.5', '0.50'],
            ['41', '30', '12.30'],
            ['4', '2', '0.08'],
            ['0.33', '3', '0.00'],
        ];
    }
}
