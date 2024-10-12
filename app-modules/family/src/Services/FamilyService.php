<?php

namespace Dzorogh\Family\Services;

use AnourValar\EloquentSerialize\Package;
use Dzorogh\Family\Models\FamilyCouple;
use Dzorogh\Family\Models\FamilyPerson;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use stdClass;

class FamilyService
{
    /**
     * @param \Illuminate\Support\Collection $people
     * @return FamilyTreeData
     */
    private function getSubCouplesData(\Illuminate\Support\Collection $people): FamilyTreeData
    {
        $result = new FamilyTreeData();

        if (!$people->count()) {
            return $result;
        }

        $subCouplesHusband = FamilyCouple::with(['wife' => fn($q) => $q->withCount(['photos', 'contacts']), 'children' => fn($q) => $q->withCount(['photos', 'contacts'])])
            ->whereIn('husband_id', $people->map->id)->get();
        $subCouplesWife = FamilyCouple::with(['husband' => fn($q) => $q->withCount(['photos', 'contacts']), 'children' => fn($q) => $q->withCount(['photos', 'contacts'])])
            ->whereIn('wife_id', $people->map->id)->get();

        $result->people->push(...$subCouplesHusband->flatMap->children);
        $result->people->push(...$subCouplesWife->flatMap->children);

        // get children data
        $subCouplesData = $this->getSubCouplesData($result->people);
        $result->people->push(...$subCouplesData->people);
        $result->couples->push(...$subCouplesData->couples);

        $result->couples->push(...$subCouplesHusband);
        $result->couples->push(...$subCouplesWife);

        $wives = $subCouplesHusband->map->wife;
        $husbands = $subCouplesWife->map->husband;

        $result->people->push(...$wives->filter());
        $result->people->push(...$husbands->filter());

        return $result;
    }

    /**
     * @param int $rootPersonId
     * @return FamilyTreeData
     */
    public function makeTree(int $rootPersonId): FamilyTreeData
    {
        $result = new FamilyTreeData();

        /** @var FamilyPerson $mainPerson */
        $mainPerson = FamilyPerson::find($rootPersonId);
        $mainPerson->loadCount(['contacts', 'photos']);
        $mainPerson->load(['parentCouple.children' => fn(FamilyPerson | HasMany $q) => $q->withCount(['contacts', 'photos'])]);

        if ($mainPerson->parentCouple) {

            $result->couples->push($mainPerson->parentCouple);

            if ($mainPerson->parentCouple->husband_id) {
                $result->people->push($mainPerson->parentCouple->husband);
            }

            if ($mainPerson->parentCouple->wife_id) {
                $result->people->push($mainPerson->parentCouple->wife);
            }

            $siblings = $mainPerson->parentCouple->children;
            $result->people->push(...$siblings);
        } else {
            $result->people->push($mainPerson);
        }

        $data = $this->getSubCouplesData($result->people);

        $result->people->push(...$data->people);
        $result->couples->push(...$data->couples);

        $result->people = $result->people->unique('id')->sortByDesc('birth_date');
        $result->couples = $result->couples->unique('id');

        return $result;
    }
}
