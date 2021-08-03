<?php

declare(strict_types=1);

namespace App\Service\Commission;

use App\DTO\Amount;
use App\DTO\Operation;
use App\Service\Math\MathServiceInterface;

final class CommissionService implements CommissionServiceInterface
{
    public function __construct(
        private MathServiceInterface $mathService,
        private CommissionRuleMapperInterface $commissionRuleMapper,
    ) {
    }

    public function getAmount(Operation $operation): Amount
    {
        $rule = $this->commissionRuleMapper->getCommissionRuleByOperation($operation);

        return $rule->setOperation($operation)->getCommissionAmount();
    }

    public function getFormattedValue(Operation $operation): string
    {
        $amount = $this->getAmount($operation);

        return $this->mathService->roundUp($amount->getValue(), $amount->getCurrency()->getScale());
    }
}
