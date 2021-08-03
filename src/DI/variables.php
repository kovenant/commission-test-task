<?php

declare(strict_types=1);

use App\DTO\CommissionSettings\Percent;
use App\DTO\CommissionSettings\PercentWithPrivilegeLimit;
use App\Enum\OperationTypes;
use App\Enum\UserTypes;

return [
    'defaultSystemCurrency' => 'EUR',
    'commission' => [
        'deposit' => new Percent('0.03'),
        'withdrawBusinessUser' => new Percent('0.5'),
        'withdrawPrivateUser' => new PercentWithPrivilegeLimit(
            '0.3',
            '0',
            '1000.00',
            3,
            'EUR'
        ),
    ],
    'defaultScale' => 8,
    'dateFormat' => 'Y-m-d',
    // [code => scale]
    'availableCurrencies' => [
        'EUR' => 2,
        'USD' => 2,
        'JPY' => 0,
    ],
    'availableUserTypes' => [
        UserTypes::PRIVATE,
        UserTypes::BUSINESS,
    ],
    'availableOperationTypes' => [
        OperationTypes::DEPOSIT,
        OperationTypes::WITHDRAW,
    ],
    'ratesApiUrl' => 'http://api.exchangeratesapi.io/v1/latest?access_key=',
    'ratesApiKey' => '88306e059357ecb0eb09212b83cd288a',
];
