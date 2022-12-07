<?php

namespace App\Http\Requests\Posts;

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
            'scope' => ['required', 'string', 'in:blog,intranet,wiki'],
            'title' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts'],
            'category' => ['nullable', 'integer', 'exists:post_categories,id'],
            'image' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'pinned' => ['required', 'boolean'],
            'status' => ['required', 'string', 'in:draft,pending,published,hidden'],
            'available_from' => ['nullable', 'date'],
            'available_to' => ['nullable', 'date'],
        ];
    }
}
