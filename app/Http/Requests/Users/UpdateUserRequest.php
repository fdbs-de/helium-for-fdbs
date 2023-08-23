<?php

namespace App\Http\Requests\Users;

use App\Permissions\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Super Admins can't be edited by anyone coming from the frontend
        if ($this->user->hasPermissionTo(Permissions::SYSTEM_SUPER_ADMIN)) return false;
        
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
            'username' => ['nullable', 'string', 'max:255', 'unique:users,username,' . $this->user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user->id],
            'password' => ['nullable', 'string', 'min:8'],
            'email_verified_at' => ['nullable', 'date'],
        ];
    }
}
