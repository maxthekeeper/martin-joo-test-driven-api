<?php

namespace App\Models;

use App\Enums\PaymentTypes;

class Salary extends Concerns\PaymentType
{
    public function monthlyAmount(): int
    {
        // Calculate the monthly salary
    }

    public function type(): string
    {
        return PaymentTypes::SALARY->value;
    }

    public function amount(): int
    {
        return $this->employee->salary;
    }
}
