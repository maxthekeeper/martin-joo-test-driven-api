<?php

it('should create a department', function () {
    $department = $this->postJson(route('departments.store'), [
        'name' => 'Development',
        'description' => 'Awesome developers across the board!',
    ])->json('data');

    expect($department)
        ->attributes->name->toBe('Development')
        ->attributes->description->toBe('Awesome developers across the board!');
});
