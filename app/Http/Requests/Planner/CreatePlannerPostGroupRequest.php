<?php

namespace App\Http\Requests\Planner;

use Illuminate\Foundation\Http\FormRequest;

class CreatePlannerPostGroupRequest extends FormRequest
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
            'slug' => ['required', 'string', 'max:255', 'unique:planner_post_groups'],
            'owner_type' => ['required', 'string', 'max:255'],
            'owner_id' => ['required', 'integer'],
            'title' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
        ];
    }
}
