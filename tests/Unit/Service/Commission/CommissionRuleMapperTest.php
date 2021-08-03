<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Commission;

use App\DTO\Amount;
use App\DTO\CommissionSettings\Percent;
use App\DTO\CommissionSettings\PercentWithPrivilegeLimit;
use App\DTO\Currency;
use App\DTO\Operation;
use App\DTO\User;
use App\Enum\OperationTypes;
use App\Enum\UserTypes;
use App\Service\Commission\CommissionRuleMapper;
use App\Service\Commission\Rule\PercentRule;
use App\Service\Commission\Rule\PercentWithPrivilegeLimitRule;
use PHPUnit\Framework\TestCase;

class CommissionRuleMapperTest extends TestCase
{
    /**
     * @dataProvider commissionRuleByOperationSuccessDataProvider
     */
    public function testGetCommissionRuleByOperationSuccess(
        string $expected,
        Operation $operation,
        array $commissionSettings
    ): void {
        $this->assertInstanceOf(
            $expected,
            $this->getCommissionRuleMapper($commissionSettings)->getCommissionRuleByOperation($operation)
        );
    }

    /**
     * @dataProvider commissionRuleByOperationExceptionDataProvider
     */
    public function testGetCommissionRuleByOperationException(
        Operation $operation,
        array $commissionSettings
    ): void {
        $this->expectException('App\Exception\InvalidCommissionSettingsException');
        $this->getCommissionRuleMapper($commissionSettings)->getCommissionRuleByOperation($operation);
    }

    private function getCommissionRuleMapper(array $commissionSettings): CommissionRuleMapper
    {
        return new CommissionRuleMapper(
            $commissionSettings,
            [
                $this->createMock(PercentRule::class),
                $this->createMock(PercentWithPrivilegeLimitRule::class),
            ]
        );
    }

    public function commissionRuleByOperationSuccessDataProvider(): array
    {
        $settings = $this->getCorrectSettings();

        return [
            [
                PercentRule::class,
                new Operation(
                    new \DateTime(),
                    new User(1, UserTypes::PRIVATE),
                    OperationTypes::DEPOSIT,
                    new Amount('10', new Currency('EUR', '1', 2))
                ),
                $settings
            ],
            [
                PercentRule::class,
                new Operation(
                    new \DateTime(),
                    new User(1, UserTypes::BUSINESS),
                    OperationTypes::DEPOSIT,
                    new Amount('1000', new Currency('EUR', '1', 2))
                ),
                $settings
            ],
            [
                PercentWithPrivilegeLimitRule::class,
                new Operation(
                    new \DateTime(),
                    new User(1, UserTypes::PRIVATE),
                    OperationTypes::WITHDRAW,
                    new Amount('10000', new Currency('JPY', '129.53', 0))
                ),
                $settings
            ],
            [
                PercentRule::class,
                new Operation(
                    new \DateTime(),
                    new User(1, UserTypes::BUSINESS),
                    OperationTypes::WITHDRAW,
                    new Amount('100', new Currency('USD', '1.1497', 2))
                ),
                $settings
            ],
        ];
    }

    public function commissionRuleByOperationExceptionDataProvider(): array
    {
        $correctSettings = $this->getCorrectSettings();

        return [
            [
                new Operation(
                    new \DateTime(),
                    new User(1, UserTypes::BUSINESS),
                    'bad',
                    new Amount('1000', new Currency('EUR', '1', 2))
                ),
                $correctSettings
            ],
            [
                new Operation(
                    new \DateTime(),
                    new User(1, 'bad'),
                    OperationTypes::WITHDRAW,
                    new Amount('10', new Currency('EUR', '1', 2))
                ),
                $correctSettings
            ],
            [
                new Operation(
                    new \DateTime(),
                    new User(1, UserTypes::BUSINESS),
                    'deposit',
                    new Amount('10', new Currency('EUR', '1', 2))
                ),
                [
                    'withdrawBusinessUser' => new Percent('0.6'),
                    'withdrawPrivateUser' => new PercentWithPrivilegeLimit(
                        '0.2',
                        '1',
                        '2000.00',
                        4,
                        'USD'
                    ),
                ]
            ],
            [
                new Operation(
                    new \DateTime(),
                    new User(1, UserTypes::BUSINESS),
                    'deposit',
                    new Amount('10', new Currency('EUR', '1', 2))
                ),
                [
                    'deposit' => new \stdClass(),
                    'withdrawBusinessUser' => new Percent('0.6'),
                    'withdrawPrivateUser' => new PercentWithPrivilegeLimit(
                        '0.2',
                        '1',
                        '2000.00',
                        4,
                        'USD'
                    ),
                ]
            ],
        ];
    }

    private function getCorrectSettings(): array
    {
        return [
            'deposit' => new Percent('0.04'),
            'withdrawBusinessUser' => new Percent('0.6'),
            'withdrawPrivateUser' => new PercentWithPrivilegeLimit(
                '0.2',
                '1',
                '2000.00',
                4,
                'USD'
            ),
        ];
    }
}
