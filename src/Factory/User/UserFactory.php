<?php

declare(strict_types=1);

namespace App\Factory\User;

use App\DTO\User;
use App\Exception\InvalidUserIdException;
use App\Exception\InvalidUserTypeException;

final class UserFactory implements UserFactoryInterface
{
    /**
     * @param string[] $availableUserTypes
     */
    public function __construct(
        private array $availableUserTypes
    ) {
    }

    public function build(string $userId, string $userType): User
    {
        if ((int)$userId < 1) {
            throw new InvalidUserIdException($userId, 'Invalid user ID');
        }

        if (!in_array($userType, $this->availableUserTypes, true)) {
            throw new InvalidUserTypeException($userType, 'Invalid user type');
        }

        return new User((int)$userId, $userType);
    }
}
