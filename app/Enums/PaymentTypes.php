<?php

namespace App\Enums;

use App\Models\Concerns\PaymentType;
use App\Models\Employee;
use App\Models\HourlyRate;
use App\Models\Salary;

enum PaymentTypes: string
{
    case SALARY = 'salary';
    case HOURLY_RATE = 'hourlyRate';

    public function makePaymentType(Employee $employee): PaymentType
    {
        return match ($this) {
            self::SALARY => new Salary($employee),
            self::HOURLY_RATE => new HourlyRate($employee),
        };
    }
}
