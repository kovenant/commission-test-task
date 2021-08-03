<?php

declare(strict_types=1);

namespace App\Factory\Operation;

use App\DTO\Operation;
use App\Exception\InvalidDateException;
use App\Exception\InvalidOperationTypeException;
use App\Factory\Amount\AmountFactoryInterface;
use App\Factory\Currency\CurrencyFactoryInterface;
use App\Factory\User\UserFactoryInterface;

final class OperationFactory implements OperationFactoryInterface
{
    /**
     * @param string[] $availableOperationTypes
     * @param string $dateFormat
     * @param CurrencyFactoryInterface $currencyFactory
     * @param AmountFactoryInterface $amountFactory
     * @param UserFactoryInterface $userFactory
     */
    public function __construct(
        private array $availableOperationTypes,
        private string $dateFormat,
        private CurrencyFactoryInterface $currencyFactory,
        private AmountFactoryInterface $amountFactory,
        private UserFactoryInterface $userFactory,
    ) {
    }

    public function build(
        string $date,
        string $userId,
        string $userType,
        string $operationType,
        string $amount,
        string $currencyCode,
    ): Operation {
        if (!in_array($operationType, $this->availableOperationTypes, true)) {
            throw new InvalidOperationTypeException($operationType, 'Invalid operation type');
        }

        $currency = $this->currencyFactory->build($currencyCode);
        $amountDTO = $this->amountFactory->build($amount, $currency);
        $user = $this->userFactory->build($userId, $userType);
        $dateTime = \DateTime::createFromFormat($this->dateFormat, $date);

        if (!$dateTime) {
            throw new InvalidDateException($date, 'Invalid date');
        }

        return new Operation(
            $dateTime,
            $user,
            $operationType,
            $amountDTO
        );
    }
}
