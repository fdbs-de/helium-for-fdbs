<?php

namespace App\Http\Resources\Apps\Forms;

use Illuminate\Http\Resources\Json\JsonResource;

class FrontendFormResource extends JsonResource
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
            'name' => $this->name,
            'pages' => FormPageResource::collection($this->pages),
        ];
    }
}
