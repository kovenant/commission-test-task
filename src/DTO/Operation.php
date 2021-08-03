<?php

declare(strict_types=1);

namespace App\DTO;

final class Operation
{
    public function __construct(
        private \DateTime $date,
        private User $user,
        private string $operationType,
        private Amount $amount,
    ) {
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getOperationType(): string
    {
        return $this->operationType;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }
}
