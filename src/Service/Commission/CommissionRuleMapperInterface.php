<?php

declare(strict_types=1);

namespace App\Service\Commission;

use App\DTO\Operation;

interface CommissionRuleMapperInterface
{
    public function getCommissionRuleByOperation(Operation $operation): CommissionRule;
}
