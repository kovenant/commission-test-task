<?php

declare(strict_types=1);

namespace App\Factory\User;

use App\DTO\User;

interface UserFactoryInterface
{
    public function build(string $userId, string $userType): User;
}
