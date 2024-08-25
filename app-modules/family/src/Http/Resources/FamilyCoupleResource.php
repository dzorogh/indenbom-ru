<?php

namespace Dzorogh\Family\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'id' => $this->id,
            'first_person' => FamilyPersonResource::make($this->whenLoaded('firstPerson')),
            'second_person' => FamilyPersonResource::make($this->whenLoaded('secondPerson')),
        ];
    }
}
