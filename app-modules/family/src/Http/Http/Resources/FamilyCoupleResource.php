<?php

namespace Dzorogh\Family\Http\Http\Resources;

use Dzorogh\Family\Models\FamilyCouple;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property FamilyCouple $resource
 */
class FamilyCoupleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'first_person_id' => $this->resource->first_person_id,
            'second_person_id' => $this->resource->second_person_id,
            'first_person' => FamilyPersonResource::make($this->whenLoaded('firstPerson')),
            'second_person' => FamilyPersonResource::make($this->whenLoaded('secondPerson')),
            'children' => FamilyPersonResource::collection($this->whenLoaded('children')),
        ];
    }
}
