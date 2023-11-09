<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Date\SignificantDateResource;
use App\Http\Resources\Email\EmailResource;
use App\Http\Resources\Legal\LegalDetailResource;
use App\Http\Resources\Link\WebsiteLinkResource;
use App\Http\Resources\Payment\BankDetailsResource;
use App\Http\Resources\PhoneNumber\PhoneNumberResource;
use App\Models\Address;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'legal_form' => $this->legal_form,
            'description' => $this->description,
            'notes' => $this->notes,

            'addresses' => AddressResource::collection($this->addresses),
            'legal_details' => LegalDetailResource::collection($this->legal_details),
            'bank_details' => BankDetailsResource::collection($this->bank_details),
            'phone_numbers' => PhoneNumberResource::collection($this->phone_numbers),
            'emails' => EmailResource::collection($this->emails),
            'website_links' => WebsiteLinkResource::collection($this->website_links),
            'significant_dates' => SignificantDateResource::collection($this->significant_dates),

            'legal_address' => AddressResource::make($this->legal_address),
            'billing_address' => AddressResource::make($this->billing_address),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
