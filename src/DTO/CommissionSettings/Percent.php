<?php

declare(strict_types=1);

namespace App\DTO\CommissionSettings;

use App\Service\Commission\Rule\PercentRule;

class Percent extends CommissionSetting
{
    public function __construct(
        protected string $commissionPercent
    ) {
    }

    public function getCommissionPercent(): string
    {
        return $this->commissionPercent;
    }

    public function getRuleClass(): string
    {
        return PercentRule::class;
    }
}
