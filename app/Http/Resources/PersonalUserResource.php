<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalUserResource extends JsonResource
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
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'enabled_at' => $this->enabled_at,
            'is_enabled' => $this->is_enabled,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'access' => $this->access,
            'profiles' => $this->profiles,
            'roles' => $this->roles,
            'permissions' => $this->permissions,
            'permission_list' => $this->getAllPermissions()->pluck('name')->toArray(),
            'settings' => $this->settings,
            'settings_object' => $this->settings_object,
        ];
    }
}
