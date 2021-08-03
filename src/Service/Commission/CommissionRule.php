<?php

declare(strict_types=1);

namespace App\Service\Commission;

use App\DTO\Amount;
use App\DTO\Commission;
use App\DTO\CommissionSettings\CommissionSetting;
use App\DTO\Operation;

abstract class CommissionRule
{
    protected Operation $operation;
    protected CommissionSetting $settings;

    public function setOperation(Operation $operation): static
    {
        $this->operation = $operation;

        return $this;
    }

    public function setSettings(CommissionSetting $settings): static
    {
        $this->settings = $settings;

        return $this;
    }

    abstract public function getCommission(): Commission;

    abstract public function getCommissionAmount(): Amount;
}
