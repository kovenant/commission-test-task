<?php

declare(strict_types=1);

namespace App\Service\Math;

interface MathServiceInterface
{
    public function add(string $leftOperand, string $rightOperand): string;

    public function sub(string $leftOperand, string $rightOperand): string;

    public function mul(string $leftOperand, string $rightOperand): string;

    public function div(string $leftOperand, string $rightOperand): string;

    public function percent(string $fromValue, string $percent): string;

    public function getMax(string $leftOp, string $rightOp): string;

    public function isEqual(string $leftOp, string $rightOp): bool;

    public function isRightBigger(string $leftOp, string $rightOp): bool;

    public function compare(string $leftOp, string $rightOp): int;

    public function isLeftBigger(string $leftOp, string $rightOp): bool;

    public function getMin(string $leftOp, string $rightOp): string;

    public function roundUp(string $value, int $scale): string;

    public function roundDown(string $value, int $scale): string;
}
