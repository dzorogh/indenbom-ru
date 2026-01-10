<?php

namespace Dzorogh\Family\Http\Resources;

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
        $media = $this->resource->getMedia()->first();
        
        return [
            'id' => $this->resource->id,
            'media_url' => $this->getMediaUrl($media),
            'description' => $this->resource->description,
            'place' => $this->resource->place,
            'approximate_date' => $this->resource->approximate_date,

            'people' => FamilyPersonResource::collection($this->whenLoaded('people')),

            'order' => $this->whenPivotLoaded('family_person_photo', function () {
                return $this->pivot->order;
            }),
        ];
    }

    /**
     * Получить полный URL для медиа файла
     */
    private function getMediaUrl($media): ?string
    {
        if (!$media) {
            return null;
        }
        
        $url = $media->getUrl();
        
        // Если URL не содержит домен, добавляем его
        if ($url && !str_starts_with($url, 'http')) {
            return url($url);
        }
        
        return $media->getFullUrl() ?: $url;
    }
}
