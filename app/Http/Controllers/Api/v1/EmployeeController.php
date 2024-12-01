<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\UpsertEmployeeAction;
use App\DataTransferObjects\EmployeeData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\UpsertEmployeeRequest;
use App\Http\Resources\Api\v1\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    public function __construct(private readonly UpsertEmployeeAction $upsertEmployee)
    {}

    public function store(UpsertEmployeeRequest $request): JsonResponse
    {
        return EmployeeResource::make($this->upsert($request, new Employee()))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    private function upsert(UpsertEmployeeRequest $request, Employee $employee): Employee
    {
        $employeeData = EmployeeData::fromRequest($request);

        return $this->upsertEmployee->execute($employee, $employeeData);
    }
}
