<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\EmployeeResource;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class DepartmentEmployeeController extends Controller
{
    public function index(Department $department): AnonymousResourceCollection
    {
        $employees = QueryBuilder::for(Employee::class)
            ->allowedFilters(['full_name', 'job_title', 'email'])
            ->whereBelongsTo($department)
            ->get();

        return EmployeeResource::collection($employees);
    }
}
