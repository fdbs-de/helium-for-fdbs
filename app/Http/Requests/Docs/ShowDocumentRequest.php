<?php

namespace App\Http\Requests\Docs;

use Illuminate\Foundation\Http\FormRequest;

class ShowDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->document->group === 'customers' && !$this->user()->can_access_customer_panel) return false;
        
        if ($this->document->group === 'employees' && !$this->user()->can_access_employee_panel) return false;

        if ($this->document->group === 'hidden') return false;

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
            //
        ];
    }
}
