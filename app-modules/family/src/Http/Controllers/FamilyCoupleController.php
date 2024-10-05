<?php

namespace Dzorogh\Family\Http\Controllers;

use Dzorogh\Family\Http\Resources\FamilyCoupleResource;
use Dzorogh\Family\Models\FamilyCouple;

class FamilyCoupleController
{
    public function index()
    {
        $couples = FamilyCouple::all();

        return FamilyCoupleResource::collection($couples);
    }
}
