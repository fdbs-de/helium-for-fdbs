<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Date\SignificantDateResource;
use App\Http\Resources\Email\EmailResource;
use App\Http\Resources\Link\WebsiteLinkResource;
use App\Http\Resources\Payment\BankDetailsResource;
use App\Http\Resources\PhoneNumber\PhoneNumberResource;
use App\Http\Resources\Role\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username,
            'custom_account_id' => $this->custom_account_id,
            'image' => $this->image,
            'email' => $this->email,
            'is_enabled' => $this->is_enabled,

            'profiles' => $this->profiles,
            'details' => $this->details,
            'addresses' => AddressResource::collection($this->addresses),
            'bank_details' => BankDetailsResource::collection($this->bank_details),
            'phone_numbers' => PhoneNumberResource::collection($this->phone_numbers),
            'emails' => EmailResource::collection($this->emails),
            'website_links' => WebsiteLinkResource::collection($this->website_links),
            'significant_dates' => SignificantDateResource::collection($this->significant_dates),

            'roles' => RoleResource::collection($this->roles),
            'permissions' => $this->getAllPermissions()->pluck('name')->toArray(),

            'resources' => [
                'post_count' => $this->posts()->count(),
                'post_category_count' => $this->post_categories()->count(),
            ],
            
            'settings' => $this->settings,
            'settings_object' => $this->settings_object,

            'email_verified_at' => $this->email_verified_at,
            'enabled_at' => $this->enabled_at,
            'terminated_at' => $this->terminated_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
