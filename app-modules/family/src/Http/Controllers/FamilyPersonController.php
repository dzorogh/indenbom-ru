<?php

namespace Dzorogh\Family\Http\Controllers;

use Dzorogh\Family\Http\Requests\FamilyPersonIndexRequest;
use Dzorogh\Family\Http\Resources\FamilyPersonResource;
use Dzorogh\Family\Http\Resources\FamilyPersonTreeResource;
use Dzorogh\Family\Http\Resources\IdCollection;
use Dzorogh\Family\Models\FamilyPerson;
use Dzorogh\Family\Services\FamilyService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FamilyPersonController
{
    /**
     * List of people
     *
     * Paginated list of people with filtering and sorting
     *
     * @return AnonymousResourceCollection
     */
    public function index(FamilyPersonIndexRequest $request)
    {
        $people = FamilyPerson::search($request->validated('query'))
            ->query(function ($query) {
                $query
                    ->withCount(['photos', 'contacts'])
                    ->with([
                        'parentCouple.wife',
                        'parentCouple.husband'
                    ])
                    ->orderBy('birth_date');
            })
            ->paginate($request->validated('per_page'));

        return FamilyPersonResource::collection($people);
    }

    /**
     * Array of all people ids
     *
     * Used to prerender pages of each person
     *
     * @response array{data: int<1,>[]}
     */
    public function allIds()
    {
        $peopleIds = FamilyPerson::pluck('id');

        return new IdCollection($peopleIds);
    }

    /**
     * Person data
     *
     * @param string $personId
     * @return FamilyPersonResource
     */
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

    public function tree(string $personId, FamilyService $service)
    {
        $result = $service->makeTree($personId);
        return FamilyPersonTreeResource::make($result);
    }
}
