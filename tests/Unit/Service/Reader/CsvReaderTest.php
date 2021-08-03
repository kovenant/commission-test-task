<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Reader;

use App\Service\Reader\CsvReader;
use App\Tests\TestCase;

class CsvReaderTest extends TestCase
{
    public function testRead(): void
    {
        $csvReader = (new CsvReader())
            ->setFile($this->getFilepath('data/example.csv'))
            ->setLength(0)
            ->setDelimiter(',')
            ->setEnclosure('"')
            ->setEscape('\\');

        foreach ($csvReader->read() as $rowNumber => $row) {
            $this->assertSame($this->rowData()[$rowNumber], $row);
        }
    }

    public function rowData(): array
    {
        return [
            ['2014-12-31', '4', 'private', 'withdraw', '1200.00', 'EUR'],
            ['2015-01-01', '4', 'private', 'withdraw', '1000.00', 'EUR'],
            ['2016-01-05', '4', 'private', 'withdraw', '1000.00', 'EUR'],
            ['2016-01-05', '1', 'private', 'deposit', '200.00', 'EUR'],
            ['2016-01-06', '2', 'business', 'withdraw', '300.00', 'EUR'],
            ['2016-01-06', '1', 'private', 'withdraw', '30000', 'JPY'],
            ['2016-01-07', '1', 'private', 'withdraw', '1000.00', 'EUR'],
            ['2016-01-07', '1', 'private', 'withdraw', '100.00', 'USD'],
            ['2016-01-10', '1', 'private', 'withdraw', '100.00', 'EUR'],
            ['2016-01-10', '2', 'business', 'deposit', '10000.00', 'EUR'],
            ['2016-01-10', '3', 'private', 'withdraw', '1000.00', 'EUR'],
            ['2016-02-15', '1', 'private', 'withdraw', '300.00', 'EUR'],
            ['2016-02-19', '5', 'private', 'withdraw', '3000000', 'JPY'],
        ];
    }
}
