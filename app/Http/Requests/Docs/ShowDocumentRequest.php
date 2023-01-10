<?php

namespace App\Http\Requests\Docs;

use App\Permissions\Permissions;
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
        if ($this->document->group === 'customers' && !$this->user()->access['customer']) return false;
        if ($this->document->group === 'employees' && !$this->user()->access['employee']) return false;
        if ($this->document->group === 'hidden' && !$this->user()->access['admin']) return false;

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
