<?php

declare(strict_types=1);

namespace App\Service\Console\Input;

final class ArgvInputService implements InputServiceInterface
{
    public function getArguments(): array
    {
        return $_SERVER['argv'] ?? [];
    }

    public function getFirstArgument($default = null): string
    {
        return $_SERVER['argv'][1] ?? $default;
    }
}
