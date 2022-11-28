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
            'scope' => ['required', 'string', 'in:public,intranet,wiki'],
            'title' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts'],
            'category' => ['nullable', 'integer', 'exists:post_categories,id'],
            'content' => ['nullable', 'string'],
            'pinned' => ['required', 'boolean'],
            'status' => ['required', 'string', 'in:draft,pending,public,hidden'],
            'available_from' => ['nullable', 'date'],
            'available_to' => ['nullable', 'date'],
        ];
    }
}
