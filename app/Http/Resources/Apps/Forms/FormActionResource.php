<?php

namespace App\Http\Resources\Apps\Forms;

use Illuminate\Http\Resources\Json\JsonResource;

class FormActionResource extends JsonResource
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
            'type' => $this->type,
            'options' => $this->options,
            'order' => $this->order,
        ];
    }
}
