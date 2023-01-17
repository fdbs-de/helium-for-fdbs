<?php

namespace App\Http\Requests\Apps\Wiki;

use App\Permissions\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class ViewPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!$this->user()->can(Permissions::APP_WIKI_ACCESS_FRONTEND)) return false;

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
