<?php

namespace App\Http\Requests\Media;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionsMediaRequest extends FormRequest
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
        ];
    }
}
