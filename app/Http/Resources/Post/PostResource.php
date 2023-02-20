<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\User\PublicUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'image' => $this->image,
            'tags' => $this->tags,
            'content' => $this->content,
            'pinned' => $this->pinned,
            'status' => $this->status,
            'category' => $this->category()->first(),
            'roles' => $this->roles,
            'users' => PublicUserResource::collection($this->users),
            'available_from' => $this->available_from,
            'available_to' => $this->available_to,
            'override_category_roles' => $this->override_category_roles,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
