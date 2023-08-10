<?php

namespace App\Http\Requests\PostCategories;

use App\Permissions\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Set the current user
        $user = $this->user();

        // Set current "old" category
        $oldCategory = $this->postCategory;
        
        // First we need to find out the users relation to the post category (owner, editor, viewer)
        $relationToCategory = $oldCategory->users()->where('id', $user->id)->first();

        // Find and format the old roles
        $oldRoles = $oldCategory->roles->pluck('name')->toArray();

        // Find and format the old users
        $oldUsers = array_reduce($oldCategory->users->toArray(), function ($result, $user) {
            $result[$user['id']] = $user['pivot']['role'];
            return $result;
        }, []);

        // Find and format the new roles
        $newRoles = array_map(function ($role) { return $role['name']; }, $this->roles);

        // Find and format the new users
        $newUsers = array_reduce($this->users, function ($result, $user) {
            $result[$user['id']] = $user['pivot_role'];
            return $result;
        }, []);



        // Find the user and role delta
        $delta = [
            // Then we need to find all removed roles
            "removedRoles" => array_diff($oldRoles, $newRoles),

            // Then we need to find all added roles
            "addedRoles" => array_diff($newRoles, $oldRoles),

            // Then we need to find all removed users including their role
            "removedUsers" => array_diff_assoc($oldUsers, $newUsers),

            // Then we need to find all added users including their role
            "addedUsers" => array_diff_assoc($newUsers, $oldUsers),
        ];

        // dd($delta);



        // If user is admin we skip all other checks
        if ($user->isAdmin) return true;



        // Only users with a relation to the category may edit categories
        if ($relationToCategory === null) return false;

        // Only owners and editors may edit categories
        if (!in_array($relationToCategory->pivot->role, ['owner', 'editor'])) return false;



        // Only roles that the user has may be added
        if(!$user->hasAllRoles($delta['addedRoles'])) return false;

        // If the user is "only" an editor, they may only remove roles that they have
        if($relationToCategory->pivot->role === 'editor' && !$user->hasAllRoles($delta['removedRoles'])) return false;



        // User may not remove themself
        if (array_key_exists($user->id, $delta['removedUsers'])) return false;

        // Owner may not be removed
        // We filter both the specific owner and search for the "owner" role
        if (array_key_exists($oldCategory->owner->first()->id, $delta['removedUsers'])) return false;
        if (in_array('owner', $delta['removedUsers'])) return false;

        // Owner may not be added
        // With this rule we cover that the editors may add and remove editors and viewers but not the owner
        if (in_array('owner', $delta['addedUsers'])) return false;

        

        // Finally we allow the request
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(['scope' => $this->app['id']]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'scope' => ['required'],
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', 'unique:post_categories,slug,' . $this->postCategory->id . ',id,scope,' . $this->scope],
            'color' => 'nullable|string|max:31',
            'icon' => 'nullable|string|max:31',
            'description' => 'nullable|string',
            'status' => 'required|string|in:published,hidden',

            // May only be the roles that the user has the permission to assign
            'roles' => ['nullable', 'array'],
            'roles.*.id' => ['nullable', 'exists:roles,id', 'distinct', 'in:' . implode(',', $this->user()->available_role_ids)],

            // As the owner gets added automatically,
            // we need to make sure that the owner user is not in the list
            'users' => ['nullable', 'array'],
            'users.*.id' => ['nullable', 'exists:users,id', 'distinct'],
            'users.*.pivot_role' => ['nullable', 'string', 'in:owner,editor,viewer'],
        ];
    }



    public function passedValidation()
    {
        $this->merge([
            'users' => array_reduce($this->users, function ($result, $user) {
                $result[$user['id']] = ['role' => $user['pivot_role']];
                return $result;
            }, []),
            'roles' => array_map(function ($role) {
                return $role['id'];
            }, $this->roles),
        ]);
    }
}
