<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\DI\Bootstrap;
use App\Processor\FileCommissionProcessor\FileCommissionProcessorInterface;

$container = (new Bootstrap())->getContainer();

$output = $container->get(FileCommissionProcessorInterface::class);
$output->process();
