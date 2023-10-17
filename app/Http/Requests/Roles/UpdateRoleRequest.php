<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:roles,name,' . $this->role->id,
            'color' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'required|string|exists:permissions,name',
        ];
    }
}
