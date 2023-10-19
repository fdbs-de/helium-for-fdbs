<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    private function getPermissions($model)
    {
        return $model->getAllPermissions()->pluck('name')->toArray();
    }
    



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
            'image' => $this->image,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'is_enabled' => $this->is_enabled,
            'roles' => $this->roles,
            'profiles' => $this->profiles,
            'permissions' => $this->getPermissions($this),
            'settings' => $this->settings,
            'settings_object' => $this->settings_object,
            'email_verified_at' => $this->email_verified_at,
            'enabled_at' => $this->enabled_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
