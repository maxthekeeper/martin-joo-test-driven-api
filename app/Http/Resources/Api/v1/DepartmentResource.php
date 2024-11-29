<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

class DepartmentResource extends JsonApiResource
{
    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
