<?php

declare(strict_types=1);

use App\Service\Commission\CommissionRuleMapper;
use App\Service\Commission\CommissionRuleMapperInterface;
use App\Service\Commission\CommissionService;
use App\Service\Commission\CommissionServiceInterface;
use App\Service\Commission\Rule\PercentRule;
use App\Service\Commission\Rule\PercentWithPrivilegeLimitRule;
use App\Service\Console\Input\InputServiceInterface;
use App\Service\Console\Input\SymfonyInputService;
use App\Service\Console\Output\OutputServiceInterface;
use App\Service\Console\Output\SymfonyOutputService;
use App\Service\CurrencyConverter\CurrencyConverterService;
use App\Service\CurrencyConverter\CurrencyConverterServiceInterface;
use App\Service\CurrencyRate\CurrencyRateFetcher;
use App\Service\CurrencyRate\CurrencyRateFetcherInterface;
use App\Service\CurrencyRate\CurrencyRateMapper;
use App\Service\CurrencyRate\CurrencyRateMapperInterface;
use App\Service\Math\BcMathService;
use App\Service\Math\MathServiceInterface;
use App\Service\Reader\CsvReader;
use App\Service\Reader\FileReader;
use Psr\Container\ContainerInterface;

return [
    FileReader::class => DI\get(CsvReader::class),
    InputServiceInterface::class => DI\get(SymfonyInputService::class),
    OutputServiceInterface::class => DI\get(SymfonyOutputService::class),
    MathServiceInterface::class => DI\factory(
        function (ContainerInterface $container) {
            return new BcMathService(
                (int)$container->get('defaultScale'),
            );
        }
    ),
    CommissionServiceInterface::class => DI\get(CommissionService::class),
    CommissionRuleMapperInterface::class => DI\autowire(CommissionRuleMapper::class)->constructor(
        DI\get('commission'),
        [
            DI\get(PercentRule::class),
            DI\get(PercentWithPrivilegeLimitRule::class),
        ]
    ),
    CurrencyRateMapperInterface::class => DI\get(CurrencyRateMapper::class),
    CurrencyConverterServiceInterface::class => DI\autowire(CurrencyConverterService::class)->constructor(
        DI\get('defaultSystemCurrency'),
    ),
    CurrencyRateFetcherInterface::class => DI\autowire(CurrencyRateFetcher::class)->constructor(
        DI\get('ratesApiUrl'),
        DI\get('ratesApiKey'),
    ),
];
