<?php

declare(strict_types=1);

namespace App\DTO\CommissionSettings;

abstract class CommissionSetting
{
    abstract public function getRuleClass(): string;
}
