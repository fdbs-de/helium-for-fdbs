<?php

namespace App\Http\Resources\Apps\Forms;

use Illuminate\Http\Resources\Json\JsonResource;

class FormInputResource extends JsonResource
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
            'key' => $this->key,
            'options' => $this->options,
            'validation' => $this->validation,
        ];
    }
}
