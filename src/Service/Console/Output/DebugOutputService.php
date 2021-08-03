<?php

declare(strict_types=1);

namespace App\Service\Console\Output;

final class DebugOutputService implements OutputServiceInterface
{
    public function print(string $string): void
    {
        echo $string;
    }

    public function printError(string $string): void
    {
        echo $string;
    }

    public function printSuccess(string $string): void
    {
        echo $string;
    }
}
