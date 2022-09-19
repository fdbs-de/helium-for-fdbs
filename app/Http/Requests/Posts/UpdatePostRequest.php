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
            'scope' => ['required', 'string', 'in:public,intranet'],
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'pinned' => ['required', 'boolean'],
            'available_from' => ['nullable', 'date'],
            'available_to' => ['nullable', 'date'],
        ];
    }
}
