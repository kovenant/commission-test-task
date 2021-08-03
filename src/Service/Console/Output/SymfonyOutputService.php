<?php

declare(strict_types=1);

namespace App\Service\Console\Output;

use Symfony\Component\Console\Output\OutputInterface;

final class SymfonyOutputService implements OutputServiceInterface
{
    private OutputInterface $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function print(string $string): void
    {
        $this->output->setDecorated(false);
        $this->output->writeln('<info>' . $string . '</info>');
    }

    public function printError(string $string): void
    {
        $this->output->setDecorated(true);
        $this->output->writeln('<error>' . $string . '</error>');
    }

    public function printSuccess(string $string): void
    {
        $this->output->setDecorated(true);
        $this->output->writeln('<info>' . $string . '</info>');
    }
}
