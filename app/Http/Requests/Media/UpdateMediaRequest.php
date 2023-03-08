<?php

namespace App\Http\Requests\Media;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMediaRequest extends FormRequest
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
            'permission_mode' => 'required|string|in:public,inherit,custom',
            'profiles' => 'nullable|array',
            'profiles.*' => 'nullable|string|max:255|distinct',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1023',
            'alt' => 'nullable|string|max:255',
        ];
    }
}
