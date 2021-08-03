<?php

declare(strict_types=1);

namespace App\Processor\FileCommissionProcessor;

use App\Exception\InvalidValueException;
use App\Factory\Operation\OperationFactoryInterface;
use App\Service\Commission\CommissionServiceInterface;
use App\Service\Console\Input\InputServiceInterface;
use App\Service\Console\Output\OutputServiceInterface;
use App\Service\Reader\FileReader;
use Psr\Log\LoggerInterface;

final class FileCommissionProcessor implements FileCommissionProcessorInterface
{
    public function __construct(
        private InputServiceInterface $inputService,
        private OutputServiceInterface $outputService,
        private OperationFactoryInterface $operationFactory,
        private CommissionServiceInterface $commissionService,
        private FileReader $fileReader,
        private LoggerInterface $logger
    ) {
    }

    public function process(): void
    {
        try {
            $filePath = $this->inputService->getFirstArgument();
            $this->outputService->printSuccess('Processing: ' . $filePath);
            $reader = $this->fileReader->setFile($filePath);

            foreach ($reader->read() as $datasetNumber => $dataset) {
                try {
                    $operation = $this->operationFactory->build(...$dataset);
                } catch (InvalidValueException $e) {
                    $this->processInvalidValue($e, $filePath);

                    continue;
                } catch (\ArgumentCountError $e) {
                    $this->processInvalidDataset($e, $datasetNumber, $filePath);

                    continue;
                }

                $commission = $this->commissionService->getFormattedValue($operation);

                $this->outputService->print($commission);
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->outputService->printError($message);
            $this->logger->error($message, ['exception' => $e]);
        }

        $this->outputService->printSuccess('Done!');
    }

    private function processInvalidValue(InvalidValueException $e, string $filePath): void
    {
        $this->outputService->printError($e->getMessage() . ': ' . $e->getInvalidValue());
        $this->logger->warning(
            $e->getMessage(),
            [
                'invalidValue' => $e->getInvalidValue(),
                'exception' => $e,
                'filepath' => $filePath,
            ]
        );
    }

    private function processInvalidDataset(\ArgumentCountError $e, int $datasetNumber, string $filePath): void
    {
        $reflector = new \ReflectionClass($this->operationFactory);

        if ($e->getFile() === $reflector->getFileName()) {
            $this->outputService->printError(sprintf('Invalid dataset %d', ++$datasetNumber));
            $this->logger->warning(
                $e->getMessage(),
                [
                    'exception' => $e,
                    'filepath' => $filePath,
                ]
            );
        }
    }
}
