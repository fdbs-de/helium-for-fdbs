<?php

namespace App\Builder;
use Illuminate\Database\Eloquent\Builder;

class PostCategoryBuilder extends Builder
{
    public function whereScope($scope = null)
    {
        // If scope is null, set to current app
        // If current app is null, set to null
        $scope = $scope ?? request()->app['id'] ?? null;

        // If scope is string, convert to array
        if (is_string($scope)) $scope = [$scope];

        // If scope is null, set to empty array
        if (is_null($scope)) $scope = [];

        // Return query
        return $this->whereIn('scope', $scope);
    }

    public function wherePublished()
    {
        return $this->where('status', 'published');
    }

    public function whereAvailable()
    {
        $roles = auth()->user()->availableRoles()->pluck('id')->toArray();
        $user = auth()->user();

        // Return all categories if user is site-admin
        if ($user->isAdmin) return $this;

        return $this
        // Categories the user has the roles to view
        ->whereHas('roles', function ($query) use ($roles) {
            $query->whereIn('id', $roles);
        })
        // Or categories where the user is added (owner, editor, viewer)
        ->orWhereHas('users', function ($query) use ($user) {
            $query->whereIn('id', [$user->id]);
        })
        // Or public categories
        ->orWhere(function ($query) {
            $query
            ->whereDoesntHave('roles')
            ->whereHas('users') // Prevent selecting categories that have no owners
            ->whereDoesntHave('usersWithoutOwner');
        });
    }

    public function whereEditable()
    {
        $user = auth()->user();

        // Return all categories if user is site-admin
        if ($user->isAdmin) return $this;

        return $this
        // Categories where the user is as owner or editor
        ->whereHas('users', function ($query) use ($user) {
            $query
            ->whereIn('id', [$user->id])
            ->whereIn('role', ['owner', 'editor']);
        });
    }
}