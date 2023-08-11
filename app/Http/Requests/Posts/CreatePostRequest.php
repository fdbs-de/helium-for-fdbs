<?php

namespace App\Http\Requests\Posts;

use App\Models\PostCategory;
use App\Permissions\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
        $this->merge([
            'scope' => $this->app['id'],
        ]);
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
            'title' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug,NULL,id,scope,' . $this->scope],
            'post_category_id' => ['required', 'integer', 'exists:post_categories,id,scope,' . $this->scope, 'in:' . implode(',', PostCategory::whereScope($this->scope)->wherePublished()->whereAvailable()->get()->pluck('id')->toArray())],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'pinned' => ['required', 'boolean'],
            'status' => ['required', 'string', 'in:draft,pending,published,hidden'],
            'available_from' => ['nullable', 'date'],
            'available_to' => ['nullable', 'date'],
            
            'override_category_roles' => ['required', 'boolean'],

            // May only be the roles that the user has the permission to assign
            'roles' => ['nullable', 'array'],
            'roles.*.id' => ['nullable', 'exists:roles,id', 'distinct', 'in:' . implode(',', $this->user()->available_role_ids)],

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
                $result[$user['id']] = [ 'role' => $user['pivot_role']];
                return $result;
            }, []),
            'roles' => array_map(function ($role) {
                return $role['id'];
            }, $this->roles),
        ]);
    }
}
