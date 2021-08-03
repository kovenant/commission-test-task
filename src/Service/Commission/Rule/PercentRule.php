<?php

declare(strict_types=1);

namespace App\Service\Commission\Rule;

use App\DTO\Amount;
use App\DTO\Commission;
use App\Factory\Amount\AmountFactoryInterface;
use App\Service\Commission\CommissionRule;
use App\Service\Math\MathServiceInterface;

class PercentRule extends CommissionRule
{
    public function __construct(
        protected MathServiceInterface $mathService,
        protected AmountFactoryInterface $amountFactory,
    ) {
    }

    public function getCommission(): Commission
    {
        $amount = $this->operation->getAmount();

        return new Commission($this->settings->getCommissionPercent(), $amount->getValue(), $amount->getCurrency());
    }

    public function getCommissionAmount(): Amount
    {
        $commission = $this->getCommission();

        $amount = $this->mathService->percent(
            $commission->getAmountForCommission(),
            $commission->getCommissionFee()
        );

        return $this->amountFactory->build($amount, $commission->getCurrencyForCommission());
    }
}
