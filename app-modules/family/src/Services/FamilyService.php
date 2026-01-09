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
     * Рекурсивно загружает всех потомков (детей, внуков и т.д.) для переданных людей.
     * Для каждого человека находит все пары, где он является мужем или женой,
     * и загружает их детей, а затем рекурсивно обрабатывает этих детей.
     *
     * @param \Illuminate\Support\Collection $people Коллекция людей, для которых нужно найти потомков
     * @return FamilyTreeData Данные о потомках (люди и пары)
     */
    private function getSubCouplesData(\Illuminate\Support\Collection $people): FamilyTreeData
    {
        $result = new FamilyTreeData();

        if (!$people->count()) {
            return $result;
        }

        // Находим все пары, где переданные люди являются мужьями
        // Загружаем жен и детей с их счетчиками (фото и контакты)
        $subCouplesHusband = FamilyCouple::with(['wife' => fn($q) => $q->withCount(['photos', 'contacts']), 'children' => fn($q) => $q->withCount(['photos', 'contacts'])])
            ->whereIn('husband_id', $people->map->id)->get();

        // Находим все пары, где переданные люди являются женами
        // Загружаем мужей и детей с их счетчиками (фото и контакты)
        $subCouplesWife = FamilyCouple::with(['husband' => fn($q) => $q->withCount(['photos', 'contacts']), 'children' => fn($q) => $q->withCount(['photos', 'contacts'])])
            ->whereIn('wife_id', $people->map->id)->get();

        // Добавляем всех детей найденных пар (потомков)
        $result->people->push(...$subCouplesHusband->flatMap->children);
        $result->people->push(...$subCouplesWife->flatMap->children);

        // Рекурсивно загружаем потомков потомков (внуков, правнуков и т.д.)
        $subCouplesData = $this->getSubCouplesData($result->people);
        $result->people->push(...$subCouplesData->people);
        $result->couples->push(...$subCouplesData->couples);

        // Добавляем найденные пары
        $result->couples->push(...$subCouplesHusband);
        $result->couples->push(...$subCouplesWife);

        // Добавляем супругов (жен мужей и мужей жен)
        $wives = $subCouplesHusband->map->wife;
        $husbands = $subCouplesWife->map->husband;

        $result->people->push(...$wives->filter());
        $result->people->push(...$husbands->filter());

        return $result;
    }

    /**
     * Рекурсивно загружает всех предков (родителей, дедушек, прадедушек и т.д.) для переданных людей.
     * Загружает только предков, без их детей (кроме тех, кто уже был в исходной коллекции).
     * Поднимается вверх по дереву до самого верха.
     *
     * @param \Illuminate\Support\Collection $people Коллекция людей, для которых нужно найти предков
     * @return FamilyTreeData Данные о предках (люди и пары)
     */
    private function getAncestorsData(\Illuminate\Support\Collection $people): FamilyTreeData
    {
        $result = new FamilyTreeData();

        if (!$people->count()) {
            return $result;
        }

        $ancestors = collect();

        foreach ($people as $person) {
            // Загружаем parentCouple если он не загружен
            if (!$person->relationLoaded('parentCouple')) {
                $person->load('parentCouple');
            }

            if ($person->parentCouple) {
                $parentCouple = $person->parentCouple;

                // Загружаем родителей (отца и мать) с их счетчиками (фото и контакты)
                // Проверяем, не загружены ли они уже, чтобы избежать лишних запросов
                if (!$parentCouple->relationLoaded('husband') && $parentCouple->husband_id) {
                    $parentCouple->load(['husband' => fn($q) => $q->withCount(['photos', 'contacts'])]);
                }
                if (!$parentCouple->relationLoaded('wife') && $parentCouple->wife_id) {
                    $parentCouple->load(['wife' => fn($q) => $q->withCount(['photos', 'contacts'])]);
                }

                // Добавляем пару родителей
                $result->couples->push($parentCouple);

                // Добавляем отца, если он есть
                if ($parentCouple->husband_id) {
                    $result->people->push($parentCouple->husband);
                    // Сохраняем для дальнейшей рекурсии (чтобы найти его родителей)
                    $ancestors->push($parentCouple->husband);
                }

                // Добавляем мать, если она есть
                if ($parentCouple->wife_id) {
                    $result->people->push($parentCouple->wife);
                    // Сохраняем для дальнейшей рекурсии (чтобы найти её родителей)
                    $ancestors->push($parentCouple->wife);
                }
            }
        }

        // Рекурсивно загружаем предков предков (дедушек, прадедушек и т.д.)
        if ($ancestors->count()) {
            $ancestorsData = $this->getAncestorsData($ancestors);
            $result->people->push(...$ancestorsData->people);
            $result->couples->push(...$ancestorsData->couples);
        }

        return $result;
    }

    /**
     * Строит полное генеалогическое дерево для указанного человека.
     * Загружает:
     * - Родителей основного человека
     * - Всех потомков родителей (братьев, сестер, племянников и т.д.)
     * - Всех предков родителей (дедушек, бабушек, прадедушек и т.д.) без их детей
     *
     * @param int $rootPersonId ID основного человека, для которого строится дерево
     * @return FamilyTreeData Полные данные генеалогического дерева
     */
    public function makeTree(int $rootPersonId): FamilyTreeData
    {
        $result = new FamilyTreeData();

        // Загружаем основного человека с его счетчиками и родительской парой
        /** @var FamilyPerson $mainPerson */
        $mainPerson = FamilyPerson::find($rootPersonId);
        $mainPerson->loadCount(['contacts', 'photos']);
        $mainPerson->load(['parentCouple.children' => fn(FamilyPerson | HasMany $q) => $q->withCount(['contacts', 'photos'])]);

        // Коллекция для хранения родителей основного человека (для последующей загрузки их предков)
        $parentsToProcess = collect();

        if ($mainPerson->parentCouple) {
            // Если у основного человека есть родители

            // Добавляем пару родителей
            $result->couples->push($mainPerson->parentCouple);

            // Добавляем отца, если он есть
            if ($mainPerson->parentCouple->husband_id) {
                $result->people->push($mainPerson->parentCouple->husband);
                // Сохраняем для последующей загрузки его предков
                $parentsToProcess->push($mainPerson->parentCouple->husband);
            }

            // Добавляем мать, если она есть
            if ($mainPerson->parentCouple->wife_id) {
                $result->people->push($mainPerson->parentCouple->wife);
                // Сохраняем для последующей загрузки её предков
                $parentsToProcess->push($mainPerson->parentCouple->wife);
            }

            // Добавляем всех братьев и сестер (детей той же родительской пары)
            $siblings = $mainPerson->parentCouple->children;
            $result->people->push(...$siblings);
        } else {
            // Если у основного человека нет родителей, добавляем только его самого
            $result->people->push($mainPerson);
        }

        // Загружаем всех потомков (детей, внуков и т.д.) для всех людей в дереве
        // Это включает племянников, двоюродных братьев и т.д.
        $data = $this->getSubCouplesData($result->people);

        $result->people->push(...$data->people);
        $result->couples->push(...$data->couples);

        // Загружаем всех предков родителей (дедушек, бабушек и выше) без их детей
        // Это поднимается вверх по дереву до самого верха
        if ($parentsToProcess->count()) {
            $ancestorsData = $this->getAncestorsData($parentsToProcess);
            $result->people->push(...$ancestorsData->people);
            $result->couples->push(...$ancestorsData->couples);
        }

        // Удаляем дубликаты и сортируем людей по дате рождения (от новых к старым)
        $result->people = $result->people->unique('id')->sortByDesc('birth_date');
        $result->couples = $result->couples->unique('id');

        return $result;
    }
}
