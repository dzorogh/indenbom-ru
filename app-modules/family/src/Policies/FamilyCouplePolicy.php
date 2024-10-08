<?php

namespace Dzorogh\Family\Policies;

use App\Models\User;
use Dzorogh\Family\Models\FamilyCouple;

class FamilyCouplePolicy
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
    public function view(?User $user, FamilyCouple $familyCouple): bool
    {
        return true;
    }
}
