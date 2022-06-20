<?php

namespace App\Policies;

use App\Models\Specification;
use App\Models\User;
use App\Permissions\Permissions;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpecificationPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        if (!$user->can(Permissions::CAN_EDIT_SPECS)) return false;

        return true;
    }
    
    public function delete(User $user)
    {
        if (!$user->can(Permissions::CAN_EDIT_SPECS)) return false;

        return true;
    }
}
