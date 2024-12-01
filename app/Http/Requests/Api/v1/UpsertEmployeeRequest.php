<?php

namespace App\Http\Requests\Api\v1;

use App\Enums\PaymentTypes;
use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpsertEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

   public function rules(): array
    {
        return [
            'fullName' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('employees', 'email')->ignore($this->employee)],
            'departmentId' => ['required', 'string', 'exists:departments,uuid'],
            'paymentType' => ['required', new Enum(PaymentTypes::class)],
            'salary' => ['nullable', 'sometimes', 'integer'],
            'hourlyRate' => ['nullable', 'sometimes', 'integer'],
        ];
    }

    public function getDepartment(): Department
    {
        return Department::where('uuid', $this->departmentId)->firstOrFail();
    }
}
