<?php

declare(strict_types=1);

namespace App\Service\Console\Input;

use Symfony\Component\Console\Input\InputInterface;

final class SymfonyInputService implements InputServiceInterface
{
    public function __construct(
        private InputInterface $input
    ) {
    }

    public function getArguments(): array
    {
        return $this->input->getArguments();
    }

    public function getFirstArgument($default = null): string
    {
        return $this->input->getFirstArgument() ?? $default;
    }
}
