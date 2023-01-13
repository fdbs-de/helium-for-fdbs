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
            'name' => 'required|string|max:255',
            'scope' => ['required', 'string', 'in:blog,intranet,wiki,jobs'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:post_categories,slug,' . $this->postCategory->id . ',id,scope,' . $this->scope],
            'color' => 'nullable|string|max:31',
            'icon' => 'nullable|string|max:31',
            'description' => 'nullable|string',
            'status' => 'required|string|in:published,hidden',
        ];
    }
}
