<?php

namespace Dzorogh\Family\Http\Controllers;

use Dzorogh\Family\Http\Resources\FamilyCoupleResource;
use Dzorogh\Family\Models\FamilyCouple;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FamilyCoupleController
{
    /**
     * List of couples
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $couples = FamilyCouple::all();

        return FamilyCoupleResource::collection($couples);
    }
}
