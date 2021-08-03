<?php

declare(strict_types=1);

namespace App\Service\Math;

class BcMathService implements MathServiceInterface
{
    public function __construct(
        private int $scale = 8
    ) {
    }

    public function add(string $leftOperand, string $rightOperand, int $scale = null): string
    {
        return bcadd($leftOperand, $rightOperand, $scale ?? $this->scale);
    }

    public function sub(string $leftOperand, string $rightOperand, int $scale = null): string
    {
        return bcsub($leftOperand, $rightOperand, $scale ?? $this->scale);
    }

    public function mul(string $leftOperand, string $rightOperand, int $scale = null): string
    {
        return bcmul($leftOperand, $rightOperand, $scale ?? $this->scale);
    }

    public function div(string $leftOperand, string $rightOperand, int $scale = null): string
    {
        return bcdiv($leftOperand, $rightOperand, $scale ?? $this->scale);
    }

    public function percent(string $fromValue, string $percent, int $scale = null): string
    {
        return $this->div($this->mul($fromValue, $percent, $scale), '100', $scale);
    }

    public function getMax(string $leftOp, string $rightOp): string
    {
        return $this->isLeftBigger($leftOp, $rightOp) ? $leftOp : $rightOp;
    }

    public function isEqual(string $leftOp, string $rightOp): bool
    {
        return $this->compare($leftOp, $rightOp) === 0;
    }

    public function isRightBigger(string $leftOp, string $rightOp): bool
    {
        return $this->compare($leftOp, $rightOp) < 0;
    }

    public function compare(string $leftOp, string $rightOp): int
    {
        return bccomp($leftOp, $rightOp, $this->scale);
    }

    public function isLeftBigger(string $leftOp, string $rightOp): bool
    {
        return $this->compare($leftOp, $rightOp) > 0;
    }

    public function getMin(string $leftOp, string $rightOp): string
    {
        return $this->isLeftBigger($leftOp, $rightOp) ? $rightOp : $leftOp;
    }

    public function roundUp(string $value, int $scale): string
    {
        $base = $this->roundDown($value, $scale);

        if (preg_match("~{$base}[0]+$~", $value) === 1 || strlen($value) <= strlen($base)) {
            return $base;
        }

        if ($scale > 0) {
            $rounder = '0.' . str_repeat('0', $scale - 1) . '1';
        } else {
            $rounder = '1';
        }

        return $this->add($base, $rounder, $scale);
    }

    public function roundDown(string $value, int $scale = null): string
    {
        return $this->mul($value, '1', $scale);
    }
}
