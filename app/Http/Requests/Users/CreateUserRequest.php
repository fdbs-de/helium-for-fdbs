<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', 'unique:users,username'],
            'custom_account_id' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:8'],

            'email_verified_at' => ['nullable', 'date'],
            'enabled_at' => ['nullable', 'date'],
            'terminated_at' => ['nullable', 'date'],

            'details' => ['nullable', 'array'],
            'details.prefix' => ['nullable', 'string', 'max:255'],
            'details.firstname' => ['nullable', 'string', 'max:255'],
            'details.middlename' => ['nullable', 'string', 'max:255'],
            'details.lastname' => ['nullable', 'string', 'max:255'],
            'details.suffix' => ['nullable', 'string', 'max:255'],
            'details.nickname' => ['nullable', 'string', 'max:255'],
            'details.legalname' => ['nullable', 'string', 'max:255'],
            'details.company' => ['nullable', 'string', 'max:255'],
            'details.department' => ['nullable', 'string', 'max:255'],
            'details.title' => ['nullable', 'string', 'max:255'],

            'addresses' => ['nullable', 'array'],
            'addresses.*.type' => ['required', 'string', 'max:255'],
            'addresses.*.address_line_1' => ['nullable', 'string', 'max:255'],
            'addresses.*.address_line_2' => ['nullable', 'string', 'max:255'],
            'addresses.*.city' => ['nullable', 'string', 'max:255'],
            'addresses.*.state' => ['nullable', 'string', 'max:255'],
            'addresses.*.postal_code' => ['nullable', 'string', 'max:255'],
            'addresses.*.country' => ['nullable', 'string', 'max:255'],
            'addresses.*.latitude' => ['nullable', 'numeric'],
            'addresses.*.longitude' => ['nullable', 'numeric'],
            'addresses.*.notes' => ['nullable', 'string', 'max:255'],

            'removed_addresses' => ['nullable', 'array'],
            'removed_addresses.*' => ['required', 'integer', 'exists:addresses,id,addressable_id,' . $this->user->id],
        ];
    }
}
