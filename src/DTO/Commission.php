<?php

declare(strict_types=1);

namespace App\DTO;

final class Commission
{
    public function __construct(
        private string $commissionFee,
        private string $amountForCommission,
        private Currency $currencyForCommission,
    ) {
    }

    public function getCommissionFee(): string
    {
        return $this->commissionFee;
    }

    public function getAmountForCommission(): string
    {
        return $this->amountForCommission;
    }

    public function getCurrencyForCommission(): Currency
    {
        return $this->currencyForCommission;
    }
}
