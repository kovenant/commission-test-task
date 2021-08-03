<?php

declare(strict_types=1);

namespace App\DTO;

final class Currency
{
    public function __construct(
        private string $code,
        private string $rate,
        private int $scale,
    ) {
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getRate(): string
    {
        return $this->rate;
    }

    public function getScale(): int
    {
        return $this->scale;
    }
}
