<?php

namespace App\Http\Resources\Api\v1;

use App\ValueObjects\Amount;
use App\ValueObjects\Money;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use TiMacDonald\JsonApi\JsonApiResource;

class EmployeeResource extends JsonApiResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->uuid,
            'type' => 'employees',
            'attributes' => $this->toAttributes($request),
        ];
    }

    public function toAttributes(Request $request): array
    {
        return [
            'fullName' => $this->full_name,
            'email' => $this->email,
            'jobTitle' => $this->job_title,
            'payment' => [
                'type' => $this->payment_type->type(),
                'amount' => Amount::from($this->payment_type->amount())->toArray(),
            ],
        ];
    }
}
