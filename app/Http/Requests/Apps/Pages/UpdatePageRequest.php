<?php

namespace App\Http\Requests\Apps\Pages;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $this->id,
            'status' => 'required|string|in:draft,published,hidden',
            'priority' => 'nullable|numeric|min:0|max:1',
            'language' => 'nullable|string|in:*,en,de,fr,es,pt,ru,zh,ja,ar',
            'content' => 'nullable',
            'meta' => 'nullable|array',
            'parent_of' => 'nullable|exists:pages,id',
            'strict_permissions' => 'nullable|boolean',
            'require_auth' => 'nullable|boolean',
            'require_verification' => 'nullable|boolean',
        ];
    }
}
