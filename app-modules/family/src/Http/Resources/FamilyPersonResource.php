<?php

namespace Dzorogh\Family\Http\Resources;

use Dzorogh\Family\Models\FamilyPerson;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @property FamilyPerson $resource
 */
class FamilyPersonResource extends JsonResource
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
            'parent_couple_id' => $this->resource->parent_couple_id,
            'full_name' => $this->resource->full_name,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'middle_name' => $this->resource->middle_name,
            'place_of_birth' => $this->resource->place_of_birth,
            'birth_date' => $this->resource->birth_date,
            'birth_date_precision' => $this->resource->birth_date_precision,
            'death_date' => $this->resource->death_date,
            'death_date_precision' => $this->resource->death_date_precision,
            'article' => $this->resource->article,
            'avatar_url' => $this->resource->getMedia('avatar')->first()?->original_url,

            'parent_couple' => FamilyCoupleResource::make($this->whenLoaded('parentCouple')),
            'couples' => FamilyCoupleResource::collection(
                $this->whenLoaded('couplesHusband', null, new Collection())
                    ->merge($this->whenLoaded('couplesWife', null, new Collection()))
            ),

            'contacts' => FamilyPersonContactResource::collection($this->whenLoaded('contacts')),
            'contacts_count' => $this->whenCounted('contacts'),
            'photos' => FamilyPhotoResource::collection($this->whenLoaded('photos')),
            'photos_count' => $this->whenCounted('photos'),


            'position_on_photo' => $this->whenPivotLoaded('family_person_photo', function () {
                return $this->pivot->position_on_photo;
            }),
        ];
    }
}
