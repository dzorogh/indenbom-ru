<?php

namespace Dzorogh\Family\Http\Controllers;

use Dzorogh\Family\Http\Requests\FamilyPersonTreeRequest;
use Dzorogh\Family\Http\Resources\FamilyPersonResource;
use Dzorogh\Family\Http\Resources\FamilyPersonTreeResource;
use Dzorogh\Family\Models\FamilyPerson;
use Dzorogh\Family\Services\FamilyService;

class FamilyPersonController
{
    public function index()
    {
        $couples = FamilyPerson::query()
            ->withCount(['photos', 'contacts'])
            ->orderBy('birth_date')
            ->get();

        return FamilyPersonResource::collection($couples);
    }

    public function show(string $personId)
    {
        $person = FamilyPerson::findOrFail($personId)
            ->load([
                'photos' => function ($q) {
                    $q->orderByPivot('order');
                },
                'photos.media',
                'photos.people',
                'contacts',
                'parentCouple.husband.couplesHusband.children',
                'parentCouple.wife.couplesWife.children',
                'parentCouple.children',
                'couplesHusband.husband',
                'couplesHusband.wife',
                'couplesHusband.children',
                'couplesWife.husband',
                'couplesWife.wife',
                'couplesWife.children'
            ]);

        return FamilyPersonResource::make($person);
    }

    public function tree(FamilyPersonTreeRequest $request, FamilyService $service)
    {
        $result = $service->makeTree($request->validated('root_person_id'));
        return FamilyPersonTreeResource::make($result);
    }
}
