<?php

declare(strict_types=1);

namespace App\Factory\Operation;

use App\DTO\Operation;

interface OperationFactoryInterface
{
    public function build(
        string $date,
        string $userId,
        string $userType,
        string $operationType,
        string $amount,
        string $currencyCode
    ): Operation;
}
