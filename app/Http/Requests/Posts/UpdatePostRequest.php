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
        if (!$this->user()->can(Permissions::CAN_EDIT_POSTS)) return false;

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'scope' => ['required', 'string', 'in:blog,intranet,wiki,jobs'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['nullable', 'exists:roles,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug,' . $this->post->id . ',id,scope,' . $this->scope],
            'category' => ['required', 'integer', 'exists:post_categories,id,scope,' . $this->scope],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'pinned' => ['required', 'boolean'],
            'status' => ['required', 'string', 'in:draft,pending,published,hidden'],
            'available_from' => ['nullable', 'date'],
            'available_to' => ['nullable', 'date'],
        ];
    }
}
