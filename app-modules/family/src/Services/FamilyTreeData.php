<?php

namespace Dzorogh\Family\Services;

use Illuminate\Database\Eloquent\Collection;

class FamilyTreeData
{
    public Collection $people;
    public Collection $couples;

    public function __construct()
    {
        $this->people = new Collection([]);
        $this->couples = new Collection([]);
    }
}
