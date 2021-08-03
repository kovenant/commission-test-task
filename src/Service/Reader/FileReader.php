<?php

declare(strict_types=1);

namespace App\Service\Reader;

use App\Exception\FileOpenException;

abstract class FileReader
{
    /** @var false|resource */
    protected $file;

    public function setFile(string $filename): self
    {
        if (file_exists($filename)) {
            $this->file = fopen($filename, 'rb');

            if ($this->file !== false) {
                return $this;
            }
        }

        throw new FileOpenException("Couldn't open file");
    }

    abstract public function read(): \Generator;
}
