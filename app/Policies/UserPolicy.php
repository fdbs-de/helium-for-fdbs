<?php

namespace App\Policies;

use App\Models\User;
use App\Permissions\Permissions;
use App\Permissions\Roles;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\user  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, user $model)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\user  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, user $model)
    {
        //
    }



    public function manageRole(User $user, user $model)
    {
        // Check permissions
        if (!$user->can(Permissions::CAN_EDIT_USERS)) return false;
        
        // Prevent user from assigning/revoking the super admin role
        if (request()->role == Roles::SUPER_ADMIN) return false;

        // Only allow super admins to assign/revoke the admin role
        if (request()->role == Roles::ADMIN && !$user->hasAnyRole([Roles::SUPER_ADMIN])) return false;

        // Only allow super admins and admins to assign/revoke the editor role
        if (request()->role == Roles::EDITOR && !$user->hasAnyRole([Roles::SUPER_ADMIN, Roles::ADMIN])) return false;

        return true;
    }



    public function enable(User $user, user $model)
    {
        if (!$user->can(Permissions::CAN_EDIT_USERS)) return false;

        // Prevent enabling self
        if ($user->id == $model->id) return false;

        return true;
    }



    public function disable(User $user, user $model)
    {
        if (!$user->can(Permissions::CAN_EDIT_USERS)) return false;

        // Prevent disabling self
        if ($user->id == $model->id) return false;

        return true;
    }

    

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\user  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, user $model)
    {
        // Check permissions
        if (!$user->can(Permissions::CAN_EDIT_USERS)) return false;

        // Prevent deleting self
        if ($user->id == $model->id) return false;

        // Prevent deleting super admin
        if ($model->hasRole(Roles::SUPER_ADMIN)) return false;

        // Prevent deleting admin
        if (!$user->hasRole(Roles::SUPER_ADMIN) && $model->hasRole(Roles::ADMIN)) return false;

        return true;
    }

    public function deleteProfile(User $user, user $model)
    {
        // Check permissions or if self
        if (!$user->can(Permissions::CAN_EDIT_USERS) && $user->id != $model->id) return false;

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\user  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, user $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\user  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, user $model)
    {
        //
    }
}
