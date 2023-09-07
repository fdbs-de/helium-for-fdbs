<?php

namespace App\Http\Resources\Apps\Pages;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
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
            'status' => $this->status,
            'name' => $this->name,
            'content' => $this->content,
            'default_for' => $this->default_for,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
