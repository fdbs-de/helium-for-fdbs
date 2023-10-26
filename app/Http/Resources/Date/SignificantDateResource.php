<?php

namespace App\Http\Resources\Date;

use Illuminate\Http\Resources\Json\JsonResource;

class SignificantDateResource extends JsonResource
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
            'date' => $this->date,
            'ignore_year' => $this->ignore_year,
            'repeats_annually' => $this->repeats_annually,
        ];
    }
}
