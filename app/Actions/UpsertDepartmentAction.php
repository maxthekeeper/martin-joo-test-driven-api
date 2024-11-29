<?php

namespace App\Actions;

use App\DataTransferObjects\DepartmentData;
use App\Models\Department;

class UpsertDepartmentAction
{
    public function execute(Department $department, DepartmentData $departmentData): Department
    {
        return Department::updateOrCreate(
            ['id' => $department->id],
            [
                'name' => $departmentData->name,
                'description' => $departmentData->description,
            ]
        );
    }
}
