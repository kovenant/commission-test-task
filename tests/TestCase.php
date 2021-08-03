<?php

declare(strict_types=1);

namespace App\Tests;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function getFilepath(string $filename): string
    {
        foreach (
            [
                '/vendor/',
                '/bin/phpunit',
            ] as $needle
        ) {
            $dir = stristr($_SERVER['SCRIPT_FILENAME'], $needle, true);

            if ($dir) {
                return $dir . '/' . $filename;
            }
        }

        return $filename;
    }
}
