<?php

declare(strict_types=1);

namespace App\Exception;

final class InvalidCommissionSettingsException extends \LogicException
{
    protected string $invalidSettingsKey;

    public function __construct(
        string $invalidSettingsKey,
        string $message = '',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->invalidSettingsKey = $invalidSettingsKey;
    }
}
