<?php

namespace Database\Factories;

use App\Enums\PaymentTypes;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'department_id' => Department::factory()->create()->uuid,
            'full_name' => $this->faker->name,
            'email' => $this->faker->email,
            'job_title' => $this->faker->word,
            'payment_type' => PaymentTypes::SALARY->value,
            'salary' => $this->faker->numberBetween(2000, 5000),
        ];
    }
}
