<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory\Operation;

use App\DTO\Operation;
use App\Enum\OperationTypes;
use App\Enum\UserTypes;
use App\Factory\Amount\AmountFactory;
use App\Factory\Currency\CurrencyFactory;
use App\Factory\Operation\OperationFactory;
use App\Factory\User\UserFactory;
use App\Service\CurrencyRate\CurrencyRateMapperInterface;
use PHPUnit\Framework\TestCase;

class OperationFactoryTest extends TestCase
{
    /**
     * @dataProvider buildSuccessDataProvider
     */
    public function testSuccessBuild(
        string $date,
        string $userId,
        string $userType,
        string $operationType,
        string $amount,
        string $currencyCode
    ): void {
        $service = $this->getOperationFactory();
        $operation = $service->build($date, $userId, $userType, $operationType, $amount, $currencyCode);
        self::assertInstanceOf(Operation::class, $operation);
    }

    /**
     * @dataProvider buildInvalidOperationTypeDataProvider
     */
    public function testBuildInvalidOperationType(
        string $date,
        string $userId,
        string $userType,
        string $operationType,
        string $amount,
        string $currencyCode
    ): void {
        $service = $this->getOperationFactory();
        $this->expectException('App\Exception\InvalidOperationTypeException');
        $service->build($date, $userId, $userType, $operationType, $amount, $currencyCode);
    }

    /**
     * @dataProvider buildInvalidCurrencyDataProvider
     */
    public function testBuildInvalidCurrency(
        string $date,
        string $userId,
        string $userType,
        string $operationType,
        string $amount,
        string $currencyCode
    ): void {
        $service = $this->getOperationFactory();
        $this->expectException('App\Exception\InvalidCurrencyException');
        $service->build($date, $userId, $userType, $operationType, $amount, $currencyCode);
    }

    /**
     * @dataProvider buildInvalidUserTypeDataProvider
     */
    public function testBuildInvalidUserType(
        string $date,
        string $userId,
        string $userType,
        string $operationType,
        string $amount,
        string $currencyCode
    ): void {
        $service = $this->getOperationFactory();
        $this->expectException('App\Exception\InvalidUserTypeException');
        $service->build($date, $userId, $userType, $operationType, $amount, $currencyCode);
    }

    /**
     * @dataProvider buildInvalidUserIdDataProvider
     */
    public function testBuildInvalidUserId(
        string $date,
        string $userId,
        string $userType,
        string $operationType,
        string $amount,
        string $currencyCode
    ): void {
        $service = $this->getOperationFactory();
        $this->expectException('App\Exception\InvalidUserIdException');
        $service->build($date, $userId, $userType, $operationType, $amount, $currencyCode);
    }

    /**
     * @dataProvider buildInvalidAmountValueDataProvider
     */
    public function testBuildInvalidAmountValue(
        string $date,
        string $userId,
        string $userType,
        string $operationType,
        string $amount,
        string $currencyCode
    ): void {
        $service = $this->getOperationFactory();
        $this->expectException('App\Exception\InvalidAmountValueException');
        $service->build($date, $userId, $userType, $operationType, $amount, $currencyCode);
    }

    /**
     * @dataProvider buildInvalidDateDataProvider
     */
    public function testBuildInvalidDate(
        string $date,
        string $userId,
        string $userType,
        string $operationType,
        string $amount,
        string $currencyCode
    ): void {
        $service = $this->getOperationFactory();
        $this->expectException('App\Exception\InvalidDateException');
        $service->build($date, $userId, $userType, $operationType, $amount, $currencyCode);
    }

    public function buildSuccessDataProvider(): array
    {
        return [
            ['2014-12-31', '4', 'private', 'withdraw', '1200.00', 'EUR'],
            ['2015-01-01', '4', 'private', 'withdraw', '0.00', 'EUR'],
            ['2016-01-05', '4', 'private', 'withdraw', '1000', 'EUR'],
            ['2016-01-06', '1', 'private', 'withdraw', '30000', 'JPY'],
            ['2016-01-07', '1', 'private', 'withdraw', '1000.00000000000', 'EUR'],
            ['2016-01-07', '1', 'private', 'withdraw', '100.00', 'USD'],
            ['2016-02-19', '5', 'private', 'withdraw', '3000000', 'JPY'],
            ['2016-01-06', '3', 'business', 'withdraw', '1.00', 'EUR'],
            ['2016-01-06', '3', 'business', 'withdraw', '25.00', 'USD'],
            ['2016-01-06', '3', 'business', 'withdraw', '3000.00', 'JPY'],
            ['2016-01-10', '2', 'business', 'deposit', '10000.00', 'EUR'],
            ['2016-01-10', '2', 'business', 'deposit', '10000.00', 'JPY'],
            ['2016-01-10', '2', 'business', 'deposit', '10000.00', 'USD'],
            ['2016-01-05', '1', 'private', 'deposit', '200.00', 'EUR'],
            ['2016-01-05', '1', 'private', 'deposit', '200.00', 'JPY'],
            ['2016-01-05', '1', 'private', 'deposit', '200.00', 'USD'],
            ['2016-01-10', '300', 'private', 'withdraw', '1000.00', 'EUR'],
        ];
    }

    private function getOperationFactory(): OperationFactory
    {
        $currencyRateMapper = $this->createMock(CurrencyRateMapperInterface::class);
        $currencyRateMapper->method('getRate')->willReturn('1');

        return new OperationFactory(
            [
                OperationTypes::WITHDRAW,
                OperationTypes::DEPOSIT,
            ],
            'Y-m-d',
            new CurrencyFactory(
                [
                    'EUR' => 2,
                    'USD' => 2,
                    'JPY' => 0,
                ],
                $currencyRateMapper,
            ),
            new AmountFactory(),
            new UserFactory(
                [
                    UserTypes::BUSINESS,
                    UserTypes::PRIVATE,
                ]
            ),
        );
    }

    public function buildInvalidOperationTypeDataProvider(): array
    {
        return [
            ['2014-12-31', '4', 'private', 'invalid', '1200.00', 'EUR'],
            ['2015-01-01', '4', 'private', '', '1200.00', 'USD'],
        ];
    }

    public function buildInvalidCurrencyDataProvider(): array
    {
        return [
            ['2014-12-31', '4', 'private', 'withdraw', '1200.00', 'WTF'],
            ['2015-01-01', '4', 'private', 'deposit', '1200.00', ''],
        ];
    }

    public function buildInvalidUserTypeDataProvider(): array
    {
        return [
            ['2015-01-01', '4', 'baduser', 'deposit', '1200.00', 'EUR'],
            ['2014-12-31', '4', '', 'withdraw', '1200.00', 'USD'],
        ];
    }

    public function buildInvalidUserIdDataProvider(): array
    {
        return [
            ['2014-12-31', '0', 'private', 'withdraw', '1200.00', 'EUR'],
            ['2015-01-01', '', 'private', 'deposit', '1200.00', 'USD'],
        ];
    }

    public function buildInvalidAmountValueDataProvider(): array
    {
        return [
            ['2014-12-31', '4', 'private', 'withdraw', 'bad', 'EUR'],
            ['2014-12-31', '4', 'private', 'withdraw', '1bad', 'EUR'],
            ['2014-12-31', '4', 'private', 'withdraw', 'bad1', 'EUR'],
            ['2014-12-31', '4', 'private', 'withdraw', '2,85', 'EUR'],
            ['2015-01-01', '4', 'private', 'deposit', '', 'USD'],
        ];
    }

    public function buildInvalidDateDataProvider(): array
    {
        return [
            ['12-11-2007', '4', 'private', 'withdraw', '1200.00', 'EUR'],
            ['2020/05/31', '4', 'private', 'withdraw', '1200.00', 'USD'],
            ['now', '4', 'private', 'withdraw', '1200.00', 'EUR'],
            ['', '4', 'private', 'deposit', '1200.00', 'USD'],
        ];
    }
}
