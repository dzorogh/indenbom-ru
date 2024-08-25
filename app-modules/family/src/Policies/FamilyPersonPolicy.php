<?php

namespace Dzorogh\Family\Policies;

use App\Models\User;
use Dzorogh\Family\Models\FamilyPerson;
use Illuminate\Auth\Access\Response;

class FamilyPersonPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, FamilyPerson $familyPerson): bool
    {
        return true;
    }
}
