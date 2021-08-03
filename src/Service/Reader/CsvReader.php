<?php

declare(strict_types=1);

namespace App\Service\Reader;

final class CsvReader extends FileReader
{
    private int $length = 0;
    private string $delimiter = ',';
    private string $enclosure = '"';
    private string $escape = '\\';

    public function read(): \Generator
    {
        while (!feof($this->file)) {
            yield array_map('trim', (array)$this->fGetCsv());
        }
    }

    private function fGetCsv(): array|false
    {
        return fgetcsv($this->file, $this->length, $this->delimiter, $this->enclosure, $this->escape);
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function setDelimiter(string $delimiter): self
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    public function setEnclosure(string $enclosure): self
    {
        $this->enclosure = $enclosure;

        return $this;
    }

    public function setEscape(string $escape): self
    {
        $this->escape = $escape;

        return $this;
    }
}
