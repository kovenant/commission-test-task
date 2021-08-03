<?php

declare(strict_types=1);

namespace App\Service\Commission\Rule;

use App\DTO\Amount;
use App\DTO\Commission;
use App\DTO\CommissionSettings\CommissionSetting;
use App\DTO\CommissionSettings\PercentWithPrivilegeLimit;
use App\Factory\Amount\AmountFactoryInterface;
use App\Factory\Currency\CurrencyFactoryInterface;
use App\Service\CurrencyConverter\CurrencyConverterServiceInterface;
use App\Service\Math\MathServiceInterface;

class PercentWithPrivilegeLimitRule extends PercentRule
{
    /**
     * @var PercentWithPrivilegeLimit
     */
    protected CommissionSetting $settings;

    public function __construct(
        MathServiceInterface $mathService,
        AmountFactoryInterface $amountFactory,
        private CurrencyFactoryInterface $currencyFactory,
        private CurrencyConverterServiceInterface $currencyConverter,
    ) {
        parent::__construct($mathService, $amountFactory);
    }

    public function getCommission(): Commission
    {
        $operation = $this->operation;
        $settings = $this->settings;
        $amount = $operation->getAmount();
        $currency = $amount->getCurrency();
        $amountValue = $amount->getValue();

        $historyService = new PrivilegeLimitHistoryService(
            $operation->getUser(),
            $operation->getDate(),
            $this->mathService,
        );

        $initialWithdrawAmount = $historyService->getWeeklyWithdrawAmount();
        $remainingWeeklyWithdrawAmount = $this->getRemainingWeeklyWithdrawAmount($initialWithdrawAmount);

        $limitCurrencyAmount = $this->currencyConverter->convertToDefault($amountValue, $currency);

        $weeklyWithdrawAmount = $this->mathService->add($limitCurrencyAmount, $initialWithdrawAmount);

        if ($historyService->getWeeklyWithdrawCount() < $settings->getWeeklyPrivilegeCount()) {
            $this->addAmountToWeeklyWithdrawsHistory($amount, $historyService);

            if ($this->mathService->isLeftBigger($weeklyWithdrawAmount, $settings->getWeeklyPrivilegeLimit())) {
                $commissionPercent = $settings->getCommissionPercent();
            } else {
                $commissionPercent = $settings->getPrivilegeCommissionPercent();
            }

            $amountForCommission = $this->currencyConverter->convertFromDefault(
                $this->mathService->sub($limitCurrencyAmount, $remainingWeeklyWithdrawAmount),
                $currency
            );
        } else {
            $commissionPercent = $settings->getCommissionPercent();
            $amountForCommission = $amountValue;
        }

        return new Commission(
            $commissionPercent,
            $amountForCommission,
            $currency
        );
    }

    private function getRemainingWeeklyWithdrawAmount($weeklyWithdrawAmount): string
    {
        $remainingAmount = $this->mathService->sub($this->settings->getWeeklyPrivilegeLimit(), $weeklyWithdrawAmount);

        return $this->mathService->getMax($remainingAmount, '0');
    }

    private function addAmountToWeeklyWithdrawsHistory(
        Amount $amount,
        PrivilegeLimitHistoryService $historyService
    ): void {
        $weeklyCurrency = $this->currencyFactory->build($this->settings->getLimitCurrency());
        $value = $this->currencyConverter->convert($amount->getValue(), $amount->getCurrency(), $weeklyCurrency);

        $historyService->addValueToWeeklyWithdraws($value);
    }
}
