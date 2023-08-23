<?php

namespace App\Http\Requests\Posts;

use App\Models\Post;
use App\Permissions\Permissions;
use Illuminate\Foundation\Http\FormRequest;

class DestroyPostRequest extends FormRequest
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



        // Go through each post and check if the user is allowed to delete it
        foreach ($this->ids as $id)
        {
            // Set post
            $post = Post::find($id);

            // First we need to find out the users relation to the post (owner, editor, viewer)
            $relationToPost = $post->users()->where('id', $user->id)->first();

            // Only users with a relation to the post may delete posts
            if ($relationToPost === null) return false;

            // Only owners may delete posts
            if (!in_array($relationToPost->pivot->role, ['owner'])) return false;
        }
        
        
        
        // Finally we allow the request
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
            'ids.*' => ['required', 'integer', 'exists:posts,id'],
        ];
    }
}
