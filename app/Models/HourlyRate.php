<?php

namespace App\Models;

use App\Enums\PaymentTypes;

class HourlyRate extends Concerns\PaymentType
{
    public function monthlyAmount(): int
    {
        // Calculate the amount based on time logs for the current month
    }

    public function type(): string
    {
        return PaymentTypes::HOURLY_RATE->value;
    }

    public function amount(): int
    {
        return $this->employee->hourly_rate;
    }
}
