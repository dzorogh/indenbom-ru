<?php

namespace Dzorogh\Family\Http\Resources;

use Dzorogh\Family\Models\FamilyPerson;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class FamilyPersonTreeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'people' => FamilyPersonResource::collection($this->resource->people),
            'couples' => FamilyCoupleResource::collection($this->resource->couples)
        ];
    }
}
