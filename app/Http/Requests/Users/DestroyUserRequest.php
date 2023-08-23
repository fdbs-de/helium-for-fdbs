<?php

namespace App\Http\Requests\Users;

use App\Models\User;
use App\Permissions\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class DestroyUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        foreach ($this->ids as $id)
        {
            $user = User::find($id);

            // Super Admins can't be deleted by anyone coming from the frontend
            if ($user->hasPermissionTo(Permissions::SYSTEM_SUPER_ADMIN)) return false;
        }

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
            'ids' => ['required', 'array'],
            'ids.*' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
