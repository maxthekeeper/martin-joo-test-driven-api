<?php

use App\Models\Department;
use App\Models\Employee;

it('should return 422 if email is invalid', function (?string $email) {
    $employee = Employee::factory([
        'email' => 'taken@example.com',
    ])->create();

    $this->postJson(route('employees.store'), [
        'fullName' => 'Test Employee',
        'email' => $email,
        'departmentId' => Department::factory()->create()->uuid,
        'jobTitle' => 'BE Developer',
        'paymentType' => 'salary',
        'salary' => 75000 * 100,
    ])->assertInvalid(['email']);
})->with([
    'taken@example.com',
    'invalid',
    null,
    '',
]);

it('should return 422 if payment type is invalid', function () {
    $this->postJson(route('employees.store'), [
        'fullName' => 'Test Employee',
        'email' => 'test@example.com',
        'departmentId' => Department::factory()->create()->uuid,
        'jobTitle' => 'BE Developer',
        'paymentType' => 'invalid',
        'salary' => 75000 * 100,
    ])->assertInvalid(['paymentType']);
});

it('should return 422 if salary or hourly rate missing', function (string $paymentType, ?int $salary, ?int $hourlyRate) {
    $this->postJson(route('employees.store'), [
        'fullName' => 'Test Employee',
        'email' => 'test@example.com',
        'departmentId' => Department::factory()->create()->uuid,
        'jobTitle' => 'BE Developer',
        'paymentType' => $paymentType,
        'salary' => $salary,
        'hourlyRate' => $hourlyRate,
    ])->assertInvalid([$paymentType]);
})->with([
    ['salary', null, 30 * 100],
    ['salary', 0, null],
    ['hourlyRate', 75000 * 100, null],
    ['hourlyRate', null, 0],
]);

it('should store an employee with payment type salary', function () {
    $employee = $this->postJson(route('employees.store'), [
        'fullName' => 'John Doe',
        'email' => 'test@example.com',
        'departmentId' => Department::factory()->create()->uuid,
        'jobTitle' => 'BE Developer',
        'paymentType' => 'salary',
        'salary' => 75000 * 100,
    ])->json('data');

    expect($employee)
        ->attributes->fullName->toBe('John Doe')
        ->attributes->email->toBe('test@example.com')
        ->attributes->jobTitle->toBe('BE Developer')
        ->attributes->payment->type->toBe('salary')
        ->attributes->payment->amount->cents->toBe(75000 * 100)
        ->attributes->payment->amount->dollars->toBe('$75,000.00');
});

it('should store an employee with payment type hourly rate', function () {
    $employee = $this->postJson(route('employees.store'), [
        'fullName' => 'John Doe',
        'email' => 'test@example.com',
        'departmentId' => Department::factory()->create()->uuid,
        'jobTitle' => 'BE Developer',
        'paymentType' => 'hourlyRate',
        'hourlyRate' => 30 * 100,
    ])->json('data');

    expect($employee)
        ->attributes->fullName->toBe('John Doe')
        ->attributes->email->toBe('test@example.com')
        ->attributes->jobTitle->toBe('BE Developer')
        ->attributes->payment->type->toBe('hourlyRate')
        ->attributes->payment->amount->cents->toBe(30 * 100)
        ->attributes->payment->amount->dollars->toBe('$30.00');
});
