<?php

declare(strict_types=1);

namespace App\Service\Commission\Rule;

use App\DTO\User;
use App\Service\Math\MathServiceInterface;

final class PrivilegeLimitHistoryService
{
    private static $history = [];

    public function __construct(
        private User $user,
        private \DateTime $date,
        private MathServiceInterface $mathService,
    ) {
    }

    private function getDatePeriod(): string
    {
        $date = $this->date;

        return sprintf(
            '%s-%s',
            $date->modify('this week')->format('Y-m-d'),
            $date->modify('+6 days')->format('Y-m-d')
        );
    }

    public function addValueToWeeklyWithdraws(string $value): void
    {
        $historyKey = $this->getDatePeriod();

        self::$history[$this->user->getUserId()][$historyKey][] = $value;
    }

    private function getWeeklyWithdraws(): array
    {
        $historyKey = $this->getDatePeriod();

        return self::$history[$this->user->getUserId()][$historyKey] ?? [];
    }

    public function getWeeklyWithdrawCount(): int
    {
        return count($this->getWeeklyWithdraws());
    }

    public function getWeeklyWithdrawAmount(): string
    {
        $sum = '0';

        foreach ($this->getWeeklyWithdraws() as $value) {
            $sum = $this->mathService->add($sum, $value);
        }

        return $sum;
    }
}
