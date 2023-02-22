<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    private function getPermissions($model)
    {
        return $model->getAllPermissions()->pluck('name')->toArray();
    }



    private function getProfiles($model)
    {
        $profiles = [];

        // $model->profiles is a json object
        // $model->profiles['profileName'] is either an object or null
        foreach ($model->profiles as $profileName => $profile)
        {
            if ($profile) $profiles[] = $profileName;
        }

        return $profiles;
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
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'is_enabled' => $this->is_enabled,
            'image' => $this->image,
            'roles' => $this->roles,
            'profiles' => $this->profiles,
            'permissions' => $this->getPermissions($this),
            'settings' => $this->settings,
            'settings_object' => $this->settings_object,
            'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}
