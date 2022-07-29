<?php

namespace App\Http\Requests\Docs;

use App\Permissions\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!$this->user()->can(Permissions::CAN_EDIT_DOCS)) return false;

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
            'file' => 'nullable|file|max:24576',
            'slug' => 'required|string|max:255|regex:/^[a-z0-9\-]+$/|unique:documents,slug,'.$this->document->id,
            'name' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'group' => 'nullable|string|in:customers,employees,hidden',
            'has_cover' => 'required|boolean',
            'primary_tag' => 'nullable|string|max:255',
            'tags' => 'nullable|string|max:255',

            'cover' => 'nullable|image|max:16384|mimes:png,jpg',
            'cover_alt' => 'nullable|string',
            'cover_size' => 'required_with:cover|string|in:cover,contain',
        ];
    }
}
