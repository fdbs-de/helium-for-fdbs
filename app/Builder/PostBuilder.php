<?php

namespace App\Builder;

use Illuminate\Database\Eloquent\Builder;

class PostBuilder extends Builder
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
        return $this
        ->where('status', 'published')
        ->where(function ($query) {
            $query
            ->whereDate('available_from', '<=', now())
            ->orWhere('available_from', null);
        })
        ->where(function ($query) {
            $query
            ->whereDate('available_to', '>=', now())
            ->orWhere('available_to', null);
        });
    }

    public function whereAvailable()
    {
        $roles = auth()->user() ? auth()->user()->availableRoles()->pluck('id')->toArray() : [];
        $user = auth()->user();

        // Return all categories if user is site-admin
        if (optional($user)->isAdmin) return $this;

        // Posts that are available to the user via category
        return $this
        ->where(function ($query) use ($roles, $user) {
            $query
            ->where(function ($query) use ($roles, $user) {
                $query
                // First we disregard all the posts that specifically ignore the category settings
                ->where('override_category_roles', false)
                ->where(function ($query) use ($roles, $user) {
                    $query
                    // Categories the user has the roles to view
                    ->whereHas('postCategory.roles', function ($query) use ($roles) {
                        $query->whereIn('id', $roles);
                    })
                    // Or categories where the user is added (owner, editor, viewer)
                    ->orWhereHas('postCategory.users', function ($query) use ($user) {
                        $query->whereIn('id', [optional($user)->id]);
                    })
                    // Or public categories
                    ->orWhere(function ($query) {
                        $query
                        ->whereDoesntHave('postCategory.roles')
                        ->whereHas('postCategory.users') // Prevent selecting categories that have no owners
                        ->whereDoesntHave('postCategory.usersWithoutOwner');
                    });
                });
            })
    
            // Posts the user has the roles to view
            ->orWhereHas('roles', function ($query) use ($roles) {
                $query->whereIn('id', $roles);
            })
            // Or Posts where the user is added (owner, editor, viewer)
            ->orWhereHas('users', function ($query) use ($user) {
                $query->whereIn('id', [optional($user)->id]);
            })
            // Or public posts
            ->orWhere(function ($query) {
                $query
                ->whereDoesntHave('roles')
                ->whereHas('users') // Prevent selecting posts that have no owners
                ->whereDoesntHave('usersWithoutOwner')
                ->where('override_category_roles', true); // Prevent selecting posts have no roles and no users but depend on category settings
            });
        });
    }

    public function whereEditable()
    {
        $user = auth()->user();

        // Return all categories if user is site-admin
        if (optional($user)->isAdmin) return $this;

        return $this
        // Categories where the user is as owner or editor
        ->whereHas('users', function ($query) use ($user) {
            $query
            ->whereIn('id', [optional($user)->id])
            ->whereIn('role', ['owner', 'editor']);
        });
    }
}