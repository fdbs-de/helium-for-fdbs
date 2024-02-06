<?php

namespace App\Http\Resources\Planner;

use Illuminate\Http\Resources\Json\JsonResource;

class PostGroupResource extends JsonResource
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
            'slug' => $this->slug,
            'owner_type' => $this->owner_type,
            'owner_id' => $this->owner_id,
            // 'owner_displayname' => $this->owner,
            'title' => $this->title,
            'status' => $this->status,
            // 'posts' => PostResource::collection($this->posts),
            // 'current_posts' => PostResource::collection($this->current_posts),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
