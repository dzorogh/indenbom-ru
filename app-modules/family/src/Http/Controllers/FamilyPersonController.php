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
        $couples = FamilyPerson::with(['contacts'])
            ->orderBy('birth_date', 'desc')
            ->get();

        return FamilyPersonResource::collection($couples);
    }

    public function show(string $personId)
    {
        $person = FamilyPerson::find($personId)
            ->load(['photos' => function ($q) {
                $q->orderByPivot('order');
            }, 'photos.media', 'contacts', 'parentCouple.children']);
        return FamilyPersonResource::make($person);
    }
}
