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
        // // Find the users and roles delta
        // $delta = [
        //     // Then we need to find all removed roles
        //     "removedRoles" => array_diff($this->postCategory->roles->pluck('id')->toArray(), array_map(function ($role) {
        //         return $role['id'];
        //     }, $this->roles)),

        //     // Then we need to find all added roles
        //     "addedRoles" => array_diff(array_map(function ($role) {
        //         return $role['id'];
        //     }, $this->roles), $this->postCategory->roles->pluck('id')->toArray()),

        //     // Then we need to find all removed users with their pivot_roles
        //     "removedUsers" => array_diff(array_map(function ($user) {
        //         return $user['id'];
        //     }, $this->users), $this->postCategory->users->pluck('id')->toArray()),

            

        //     // Then we need to find all added users
        //     "addedUsers" => array_diff($this->postCategory->users->pluck('id')->toArray(), array_map(function ($user) {
        //         return $user['id'];
        //     }, $this->users)),
        // ];

        // // Skip authorization if the user is an admin
        // if ($this->user()->isAdmin)
        // {
        //     // First we need to find out the users relation to the post category (owner, editor, viewer)
        //     $relation = $this->postCategory->users()->where('user_id', $this->user()->id)->first();
    
        //     if ($relation === null) return false;
    
        //     // Then we need to check if the user has the permission to edit the post category
        //     if (!in_array($relation->pivot->role, ['owner', 'editor'])) return false;
        // }

        // // check if the owner is removed
        // if (array_map(function ($user) {
        //     return $user['pivot_rolesid'];
        // }, $delta) !== $this->postCategory->users->pluck('id')->toArray())
        // {
        //     // First we need to find out the users relation to the post category (owner, editor, viewer)
        //     $relation = $this->postCategory->users()->where('user_id', $this->user()->id)->first();
    
        //     if ($relation === null) return false;
    
        //     // Then we need to check if the user has the permission to edit the post category
        //     if (!in_array($relation->pivot->role, ['owner'])) return false;
        // }


        // dd($delta);
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
