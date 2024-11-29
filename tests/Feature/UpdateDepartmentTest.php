<?php

use App\Models\Department;

it('should update a department', function (string $name, string $description) {
    $department = Department::factory([
        'name' => 'Development',
    ])->create();

    $this->putJson(route('departments.update', compact('department')), [
        'name' => $name,
        'description' => $description,
    ])->assertNoContent();

    expect(Department::find($department->id))
        ->name->toBe($name)
        ->description->toBe($description);
})->with([
    ['Development', 'Updated Description'],
    ['Development New', 'Updated Description'],
]);

it('should return 422 if name is invalid', function (?string $name) {
    Department::factory([
        'name' => 'Development',
    ])->create();

    $this->postJson(route('departments.store'), [
        'name' => $name,
        'description' => 'description',
    ])->assertInvalid(['name']);
})->with([
    '',
    null,
    'Development',
]);
