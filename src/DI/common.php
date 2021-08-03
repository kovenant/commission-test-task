<?php

declare(strict_types=1);

use App\Processor\FileCommissionProcessor\FileCommissionProcessor;
use App\Processor\FileCommissionProcessor\FileCommissionProcessorInterface;
use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

return [
    FileCommissionProcessorInterface::class => DI\get(FileCommissionProcessor::class),
    OutputInterface::class => DI\get(ConsoleOutput::class),
    ClientInterface::class => DI\get(Client::class),
    InputInterface::class => DI\get(ArgvInput::class),
    LoggerInterface::class => DI\get(NullLogger::class),
];
