<?php

declare(strict_types=1);

namespace App\DTO\CommissionSettings;

use App\Service\Commission\Rule\PercentWithPrivilegeLimitRule;

class PercentWithPrivilegeLimit extends Percent
{
    public function __construct(
        protected string $commissionPercent,
        private string $privilegeCommissionPercent,
        private string $weeklyPrivilegeLimit,
        private int $weeklyPrivilegeCount,
        private string $limitCurrency,
    ) {
        parent::__construct($commissionPercent);
    }

    public function getPrivilegeCommissionPercent(): string
    {
        return $this->privilegeCommissionPercent;
    }

    public function getWeeklyPrivilegeLimit(): string
    {
        return $this->weeklyPrivilegeLimit;
    }

    public function getWeeklyPrivilegeCount(): int
    {
        return $this->weeklyPrivilegeCount;
    }

    public function getLimitCurrency(): string
    {
        return $this->limitCurrency;
    }

    public function getRuleClass(): string
    {
        return PercentWithPrivilegeLimitRule::class;
    }
}
