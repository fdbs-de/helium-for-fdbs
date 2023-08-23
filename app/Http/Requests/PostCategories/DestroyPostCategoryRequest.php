<?php

namespace App\Http\Requests\PostCategories;

use App\Models\PostCategory;
use App\Permissions\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class DestroyPostCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Set the current user
        $user = $this->user();

        // If user is admin we skip all other checks
        if ($user->isAdmin) return true;



        // Go through each category and check if the user is allowed to delete it
        foreach ($this->ids as $id) {
            // Set category
            $postCategory = PostCategory::find($id);

            // First we need to find out the users relation to the category (owner, editor, viewer)
            $relationToCategory = $postCategory->users()->where('id', $user->id)->first();

            // Only users with a relation to the category may delete categories
            if ($relationToCategory === null) return false;

            // Only owners may delete categories
            if (!in_array($relationToCategory->pivot->role, ['owner'])) return false;
        }



        // Finally we allow the request
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'scope' => $this->app['id'],
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $availableCategoryIds = PostCategory::whereScope($this->scope)->wherePublished()->whereAvailable()->get()->pluck('id')->toArray();

        return [
            'scope' => ['required'],
            'ids' => ['required', 'array'],
            'ids.*' => ['required', 'exists:post_categories,id'],
            'replacement' => [
                'nullable',
                'exists:post_categories,id,scope,' . $this->scope,
                'in:' . implode(',', $availableCategoryIds),
                'not_in:' . implode(',', $this->ids)
            ],
        ];
    }
}
