<?php

namespace Dzorogh\Family\Http\Http\Resources;

use Dzorogh\Family\Models\FamilyPersonContact;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property FamilyPersonContact $resource
 */
class FamilyPersonContactResource extends JsonResource
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
            'type' => $this->resource->type,
            'value' => $this->resource->value
        ];
    }
}
