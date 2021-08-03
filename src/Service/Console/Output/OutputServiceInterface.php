<?php

declare(strict_types=1);

namespace App\Service\Console\Output;

interface OutputServiceInterface
{
    public function print(string $string): void;

    public function printError(string $string): void;

    public function printSuccess(string $string): void;
}
