<?php

declare(strict_types=1);

namespace App\Service\Commission;

use App\DTO\CommissionSettings\CommissionSetting;
use App\DTO\Operation;
use App\Enum\OperationTypes;
use App\Enum\SettingsKeys;
use App\Enum\UserTypes;
use App\Exception\InvalidCommissionSettingsException;

final class CommissionRuleMapper implements CommissionRuleMapperInterface
{
    /**
     * @param array $commissionSettings
     * @param CommissionRule[] $availableRules
     */
    public function __construct(
        private array $commissionSettings,
        private array $availableRules,
    ) {
    }

    public function getCommissionRuleByOperation(Operation $operation): CommissionRule
    {
        $settingsKey = $this->getSettingsKey($operation);

        $settings = $this->commissionSettings[$settingsKey] ?? null;

        if ($settings instanceof CommissionSetting) {
            foreach ($this->availableRules as $rule) {
                $ruleClass = $settings->getRuleClass();

                if ($rule instanceof $ruleClass) {
                    return $rule->setSettings($settings);
                }
            }
        }

        throw new InvalidCommissionSettingsException(
            $settingsKey,
            'Can\'t found matching rule for settings key'
        );
    }

    private function getSettingsKey(Operation $operation): string
    {
        $operationType = $operation->getOperationType();
        $userType = $operation->getUser()->getUserType();

        $settingsKey = '';

        if ($operationType === OperationTypes::DEPOSIT) {
            $settingsKey = SettingsKeys::DEPOSIT;
        } elseif ($operationType === OperationTypes::WITHDRAW) {
            if ($userType === UserTypes::BUSINESS) {
                $settingsKey = SettingsKeys::WITHDRAW_BUSINESS_USER;
            } elseif ($userType === UserTypes::PRIVATE) {
                $settingsKey = SettingsKeys::WITHDRAW_PRIVATE_USER;
            }
        }

        return $settingsKey;
    }
}
