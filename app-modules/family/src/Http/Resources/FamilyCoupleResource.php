<?php

namespace Dzorogh\Family\Http\Resources;

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
            'husband_id' => $this->resource->husband_id,
            'wife_id' => $this->resource->wife_id,
            'husband' => FamilyPersonResource::make($this->whenLoaded('husband')),
            'wife' => FamilyPersonResource::make($this->whenLoaded('wife')),
            'children' => FamilyPersonResource::collection($this->whenLoaded('children')),
        ];
    }
}
