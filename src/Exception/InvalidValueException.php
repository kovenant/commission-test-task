<?php

declare(strict_types=1);

namespace App\Exception;

abstract class InvalidValueException extends \LogicException
{
    protected string|int $invalidValue;

    public function __construct(
        string|int $invalidSettingsKey,
        string $message = '',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->invalidValue = $invalidSettingsKey;
    }

    public function getInvalidValue(): int|string
    {
        return $this->invalidValue;
    }
}
