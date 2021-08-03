<?php

declare(strict_types=1);

namespace App\Service\Console\Input;

interface InputServiceInterface
{
    public function getArguments(): array;

    public function getFirstArgument($default = null): string;
}
