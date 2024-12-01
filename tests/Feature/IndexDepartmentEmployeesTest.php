<?php

use App\Models\Department;
use App\Models\Employee;

it('should return all employees for a department', function () {
    $development = Department::factory(['name' => 'Development'])->create();
    $marketing = Department::factory(['name' => 'Marketing'])->create();

    $developers = Employee::factory([
        'department_id' => $development->uuid,
    ])->count(5)->create();

    Employee::factory([
        'department_id' => $marketing->uuid,
    ])->count(2)->create();

    $employees = $this->getJson(route('department-employees.index', [
        'department' => $development
    ]))->json('data');

    expect($employees)
        ->toHaveCount(5)
        ->each(fn ($employee) => $employee->id->toBeIn($developers->pluck('uuid')));
});

it('should filter employees', function () {
    $development = Department::factory(['name' => 'Development'])->create();
    $marketing = Department::factory(['name' => 'Marketing'])->create();

    Employee::factory([
        'department_id' => $development->uuid,
    ])->count(4)->create();

    $developer = Employee::factory([
        'full_name' => 'Test John Doe',
        'department_id' => $development->uuid,
    ])->create();

    Employee::factory([
        'department_id' => $marketing->uuid,
    ])->count(2)->create();

    $employees = $this->getJson(
        route('department-employees.index', [
            'department' => $development,
            'filter' => [
                'full_name' => 'Test',
            ],
        ]))
        ->json('data');

    expect($employees)->toHaveCount(1)
        ->and($employees[0])->id->toBe($developer->uuid);
});
