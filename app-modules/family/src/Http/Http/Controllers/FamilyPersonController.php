<?php

namespace Dzorogh\Family\Http\Http\Controllers;

use Dzorogh\Family\Http\Http\Resources\FamilyPersonResource;
use Dzorogh\Family\Models\FamilyPerson;

class FamilyPersonController
{
    public function index()
    {
        $couples = FamilyPerson::with(['contacts'])
            ->orderBy('birth_date')
            ->get();

        return FamilyPersonResource::collection($couples);
    }

    public function show(string $personId)
    {
        $person = FamilyPerson::find($personId)
            ->load([
                'photos' => function ($q) {
                    $q->orderByPivot('order');
                },
                'photos.media',
                'photos.people',
                'contacts',
                'parentCouple.firstPerson',
                'parentCouple.secondPerson',
                'couplesFirst.firstPerson',
                'couplesFirst.secondPerson',
                'couplesFirst.children',
                'couplesSecond.firstPerson',
                'couplesSecond.secondPerson',
                'couplesSecond.children'
            ]);
        return FamilyPersonResource::make($person);
    }
}
