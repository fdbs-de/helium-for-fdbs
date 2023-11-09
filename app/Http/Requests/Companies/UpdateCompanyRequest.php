<?php

namespace App\Http\Requests\Companies;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'legal_form' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1023'],
            'notes' => ['nullable', 'string', 'max:1023'],

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
            'removed_addresses.*' => ['required', 'integer', 'exists:addresses,id,addressable_id,' . $this->company->id],

            'legal_details' => ['nullable', 'array'],
            'legal_details.*.type' => ['required', 'string', 'max:255'],
            'legal_details.*.value' => ['nullable', 'string', 'max:1023'],

            'removed_legal_details' => ['nullable', 'array'],
            'removed_legal_details.*' => ['required', 'integer', 'exists:legal_details,id,governable_id,' . $this->company->id],

            'bank_details' => ['nullable', 'array'],
            'bank_details.*.type' => ['required', 'string', 'max:255'],
            'bank_details.*.bank_name' => ['nullable', 'string', 'max:255'],
            'bank_details.*.branch' => ['nullable', 'string', 'max:255'],
            'bank_details.*.account_name' => ['nullable', 'string', 'max:255'],
            'bank_details.*.account_number' => ['nullable', 'string', 'max:255'],
            'bank_details.*.swift_code' => ['nullable', 'string', 'max:255'],
            'bank_details.*.iban' => ['nullable', 'string', 'max:255'],

            'removed_bank_details' => ['nullable', 'array'],
            'removed_bank_details.*' => ['required', 'integer', 'exists:bank_details,id,bankable_id,' . $this->company->id],

            'emails' => ['nullable', 'array'],
            'emails.*.type' => ['required', 'string', 'max:255'],
            'emails.*.email' => ['required', 'string', 'email', 'max:255'],

            'removed_emails' => ['nullable', 'array'],
            'removed_emails.*' => ['required', 'integer', 'exists:emails,id,emailable_id,' . $this->company->id],

            'phone_numbers' => ['nullable', 'array'],
            'phone_numbers.*.type' => ['required', 'string', 'max:255'],
            'phone_numbers.*.number' => ['required', 'string', 'max:255'],

            'removed_phone_numbers' => ['nullable', 'array'],
            'removed_phone_numbers.*' => ['required', 'integer', 'exists:phone_numbers,id,phoneable_id,' . $this->company->id],

            'significant_dates' => ['nullable', 'array'],
            'significant_dates.*.type' => ['required', 'string', 'max:255'],
            'significant_dates.*.date' => ['required', 'date'],
            'significant_dates.*.ignore_year' => ['nullable', 'boolean'],
            'significant_dates.*.repeats_annually' => ['nullable', 'boolean'],

            'removed_significant_dates' => ['nullable', 'array'],
            'removed_significant_dates.*' => ['required', 'integer', 'exists:significant_dates,id,dateable_id,' . $this->company->id],

            'website_links' => ['nullable', 'array'],
            'website_links.*.name' => ['required', 'string', 'max:255'],
            'website_links.*.url' => ['required', 'string', 'max:255'],

            'removed_website_links' => ['nullable', 'array'],
            'removed_website_links.*' => ['required', 'integer', 'exists:website_links,id,linkable_id,' . $this->company->id],
        ];
    }
}
