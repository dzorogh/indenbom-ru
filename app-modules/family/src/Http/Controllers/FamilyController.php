<?php

namespace Dzorogh\Family\Http\Controllers;

use Dzorogh\Family\Http\Resources\FamilyResource;
use Dzorogh\Family\Models\Family;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FamilyController
{
    /**
     * List of families
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $families = Family::all();

        return FamilyResource::collection($families);
    }

    /**
     * Family by slug
     *
     * @param string $slug
     * @return FamilyResource
     */
    public function show(string $slug)
    {
        $family = Family::whereSlug($slug)->firstOrFail();

        return FamilyResource::make($family);
    }
}
