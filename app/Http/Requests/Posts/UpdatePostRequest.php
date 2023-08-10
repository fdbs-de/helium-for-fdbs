<?php

namespace App\Http\Requests\Posts;

use App\Permissions\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'roles' => ['nullable', 'array'],
            'roles.*' => ['nullable', 'exists:roles,id'],
            'users' => ['nullable', 'array'],
            'users.*.id' => ['required', 'exists:users,id'],
            'users.*.pivot_role' => ['required', 'string', 'in:author,co-author,editor,viewer'],
            'title' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug,' . $this->post->id . ',id,scope,' . $this->scope],
            'post_category_id' => ['required', 'integer', 'exists:post_categories,id,scope,' . $this->scope],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'pinned' => ['required', 'boolean'],
            'status' => ['required', 'string', 'in:draft,pending,published,hidden'],
            'override_category_roles' => ['required', 'boolean'],
            'available_from' => ['nullable', 'date'],
            'available_to' => ['nullable', 'date'],
        ];
    }



    public function passedValidation()
    {
        $this->merge([
            'users' => array_reduce($this->users, function ($result, $user) {
                $result[$user['id']] = [ 'role' => $user['pivot_role']];
                return $result;
            }, []),
        ]);
    }
}
