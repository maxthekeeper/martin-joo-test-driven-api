<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\UpsertDepartmentAction;
use App\DataTransferObjects\DepartmentData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\UpsertDepartmentRequest;
use App\Http\Resources\Api\v1\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends Controller
{
    public function __construct(
        private readonly UpsertDepartmentAction $upsertDepartment,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return DepartmentResource::collection(Department::all());
    }

    public function store(UpsertDepartmentRequest $request): JsonResponse
    {
        return DepartmentResource::make($this->upsert($request, new Department()))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Department $department): DepartmentResource
    {
        return DepartmentResource::make($department);
    }

    public function update(UpsertDepartmentRequest $request, Department $department): Response
    {
        $this->upsert($request, $department);

        return response()->noContent();
    }

    private function upsert(UpsertDepartmentRequest $request, Department $department): Department
    {
        $departmentData = new DepartmentData(...$request->validated());

        return $this->upsertDepartment->execute($department, $departmentData);
    }
}
