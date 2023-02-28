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
            'priority' => 'nullable|float|min:0|max:1',
            'content' => 'nullable|json',
        ];
    }
}
