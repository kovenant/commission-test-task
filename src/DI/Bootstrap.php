<?php

declare(strict_types=1);

namespace App\DI;

use DI\Container;
use DI\ContainerBuilder;

final class Bootstrap
{
    public function getContainer(): Container
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(__DIR__ . '/common.php');
        $builder->addDefinitions(__DIR__ . '/factories.php');
        $builder->addDefinitions(__DIR__ . '/services.php');
        $builder->addDefinitions(__DIR__ . '/variables.php');

        return $builder->build();
    }
}
