<?php

namespace Dzorogh\Family\Http\Controllers;

use Dzorogh\Family\Http\Resources\FamilyCoupleResource;
use Dzorogh\Family\Http\Resources\FamilyPersonResource;
use Dzorogh\Family\Models\FamilyCouple;
use Dzorogh\Family\Models\FamilyPerson;
use Illuminate\Http\Request;

class FamilyPersonController
{
    public function index()
    {
        $couples = FamilyPerson::all();

        return FamilyPersonResource::collection($couples);
    }
}
