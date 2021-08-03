<?php

declare(strict_types=1);

namespace App\DTO;

final class User
{
    public function __construct(
        private int $userId,
        private string $userType,
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUserType(): string
    {
        return $this->userType;
    }
}
