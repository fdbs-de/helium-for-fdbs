<?php

namespace App\Http\Requests\Media;

use App\Permissions\Permissions;
use App\Rules\MediaLibrary\MediaPath;
use Illuminate\Foundation\Http\FormRequest;

class RenameMediaRequest extends FormRequest
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
            'current_path' => ['required', 'string', new MediaPath],
            'new_path' => ['required', 'string', new MediaPath],
        ];
    }
}
