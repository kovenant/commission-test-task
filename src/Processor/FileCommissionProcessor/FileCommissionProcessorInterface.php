<?php

declare(strict_types=1);

namespace App\Processor\FileCommissionProcessor;

interface FileCommissionProcessorInterface
{
    public function process(): void;
}
