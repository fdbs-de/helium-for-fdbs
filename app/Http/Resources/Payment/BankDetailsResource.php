<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Resources\Json\JsonResource;

class BankDetailsResource extends JsonResource
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
            'bank_name' => $this->bank_name,
            'branch' => $this->branch,
            'account_name' => $this->account_name,
            'account_number' => $this->account_number,
            'swift_code' => $this->swift_code,
            'iban' => $this->iban,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
