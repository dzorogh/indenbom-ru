<?php

namespace Dzorogh\Family\Http\Http\Resources;

use Dzorogh\Family\Models\FamilyPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property FamilyPhoto $resource
 */
class FamilyPhotoResource extends JsonResource
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
            'media_url' => $this->resource->getMedia()->first()?->original_url,
            'description' => $this->resource->description,
            'place' => $this->resource->place,
            'approximate_date' => $this->resource->approximate_date,

            'people' => FamilyPersonResource::collection($this->whenLoaded('people')),

            'order' => $this->whenPivotLoaded('family_person_photo', function () {
                return $this->pivot->order;
            }),
        ];
    }
}
