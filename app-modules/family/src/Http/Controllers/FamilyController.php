<?php

namespace Dzorogh\Family\Http\Controllers;

use Dzorogh\Family\Http\Resources\FamilyResource;
use Dzorogh\Family\Models\Family;

class FamilyController
{
    public function index()
    {
        $families = Family::all();

        return FamilyResource::collection($families);
    }

    public function show(string $slug)
    {
        $family = Family::whereSlug($slug)->firstOrFail();

        return FamilyResource::make($family);
    }
}
