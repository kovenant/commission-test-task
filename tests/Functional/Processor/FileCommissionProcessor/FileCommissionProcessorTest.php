<?php

declare(strict_types=1);

namespace App\Tests\Functional\Processor\FileCommissionProcessor;

use App\DI\Bootstrap;
use App\Processor\FileCommissionProcessor\FileCommissionProcessorInterface;
use App\Service\Console\Input\InputServiceInterface;
use App\Service\Console\Output\DebugOutputService;
use App\Service\Console\Output\OutputServiceInterface;
use App\Service\CurrencyRate\CurrencyRateFetcherInterface;
use App\Tests\TestCase;
use DI\Container;
use DI\Definition\Reference;

class FileCommissionProcessorTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = (new Bootstrap())->getContainer();
        $this->container->set(OutputServiceInterface::class, new Reference(DebugOutputService::class));
    }

    public function testProcess(): void
    {
        $filepath = $this->getFilepath('data/example.csv');

        $this->expectOutputString(
            'Processing: ' . $filepath . '0.603.000.000.061.5000.700.300.303.000.000.008612Done!'
        );

        $service = $this->createMock(InputServiceInterface::class);
        $service->method('getFirstArgument')->willReturn($filepath);
        $this->container->set(InputServiceInterface::class, $service);

        $service = $this->createMock(CurrencyRateFetcherInterface::class);
        $service->method('fetchRates')->willReturn(
            [
                'EUR' => 1,
                'JPY' => 129.53,
                'USD' => 1.1497,
            ]
        );

        $this->container->set(CurrencyRateFetcherInterface::class, $service);

        $output = $this->container->get(FileCommissionProcessorInterface::class);
        $output->process();
    }

    public function testFailToOpenFile(): void
    {
        $this->expectOutputString("Processing: bad-path.csvCouldn't open fileDone!");

        $service = $this->createMock(InputServiceInterface::class);
        $service->method('getFirstArgument')->willReturn('bad-path.csv');
        $this->container->set(InputServiceInterface::class, $service);
        $output = $this->container->get(FileCommissionProcessorInterface::class);
        $output->process();
    }

    public function testInvalidFileContent(): void
    {
        $filepath = $this->getFilepath('data/invalid-example.csv');
        $this->expectOutputString(
            'Processing: ' . $filepath . 'Invalid operation type: badInvalid user type: badInvalid user ID: 0Invalid currency code: BADInvalid dataset 5Done!'
        );

        $service = $this->createMock(InputServiceInterface::class);
        $service->method('getFirstArgument')->willReturn($filepath);
        $this->container->set(InputServiceInterface::class, $service);
        $output = $this->container->get(FileCommissionProcessorInterface::class);
        $output->process();
    }
}
