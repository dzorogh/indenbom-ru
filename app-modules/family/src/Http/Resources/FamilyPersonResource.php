<?php

namespace Dzorogh\Family\Http\Resources;

use Dzorogh\Family\Models\FamilyPerson;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
        return parent::toArray($request);
    }
}
