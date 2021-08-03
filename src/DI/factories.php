<?php

declare(strict_types=1);

use App\Factory\Amount\AmountFactory;
use App\Factory\Amount\AmountFactoryInterface;
use App\Factory\Currency\CurrencyFactory;
use App\Factory\Currency\CurrencyFactoryInterface;
use App\Factory\Operation\OperationFactory;
use App\Factory\Operation\OperationFactoryInterface;
use App\Factory\User\UserFactory;
use App\Factory\User\UserFactoryInterface;

return [
    AmountFactoryInterface::class => DI\autowire(AmountFactory::class)->constructor(
        DI\get('availableCurrencies'),
    ),
    CurrencyFactoryInterface::class => DI\autowire(CurrencyFactory::class)->constructor(
        DI\get('availableCurrencies'),
    ),
    OperationFactoryInterface::class => DI\autowire(OperationFactory::class)->constructor(
        DI\get('availableOperationTypes'),
        DI\get('dateFormat'),
    ),
    UserFactoryInterface::class => DI\autowire(UserFactory::class)->constructor(
        DI\get('availableUserTypes'),
    ),
];
