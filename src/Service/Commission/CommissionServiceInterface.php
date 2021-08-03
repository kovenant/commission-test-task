<?php

declare(strict_types=1);

namespace App\Service\Commission;

use App\DTO\Amount;
use App\DTO\Operation;

interface CommissionServiceInterface
{
    public function getAmount(Operation $operation): Amount;

    public function getFormattedValue(Operation $operation): string;
}
