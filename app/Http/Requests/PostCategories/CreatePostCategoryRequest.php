<?php

namespace App\Http\Requests\PostCategories;

use App\Permissions\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'slug' => ['required', 'string', 'max:255', 'unique:post_categories,slug,NULL,id,scope,' . $this->scope],
            'color' => 'nullable|string|max:31',
            'icon' => 'nullable|string|max:31',
            'description' => 'nullable|string',
            'status' => 'required|string|in:published,hidden',

            // May only be the roles that the user has the permission to assign
            'roles' => ['nullable', 'array'],
            'roles.*.id' => ['nullable', 'exists:roles,id', 'distinct'],

            // As the owner gets added automatically,
            // we need to make sure that the owner user is not in the list
            'users' => ['nullable', 'array'],
            'users.*.id' => ['present', 'exists:users,id', 'distinct', 'not_in:' . $this->user()->id],
            'users.*.pivot_role' => ['present', 'string', 'in:editor,viewer'],
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
