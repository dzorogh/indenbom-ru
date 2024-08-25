<?php

namespace Dzorogh\Family\Http\Controllers;

use Dzorogh\Family\Http\Resources\FamilyCoupleResource;
use Dzorogh\Family\Models\FamilyCouple;
use Illuminate\Http\Request;

class FamilyTreeController
{
    public function tree()
    {
        $couples = FamilyCouple::query()
            ->with(['firstPerson', 'secondPerson'])
            ->get();

        return FamilyCoupleResource::collection($couples);
    }
}
