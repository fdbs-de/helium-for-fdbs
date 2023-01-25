<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    private function getPermissions($model)
    {
        return $model->getAllPermissions()->pluck('name')->toArray();
    }



    private function getVisual($model)
    {
        $visual = [
            'super-admin' => ['id' => 'super-admin', 'icon' => 'local_police', 'color' => 'var(--color-primary)', 'tooltip' => 'Super Admin'],
            'admin' => ['id' => 'admin', 'icon' => 'shield', 'color' => 'var(--color-primary)', 'tooltip' => 'Admin'],
            'registered' => ['id' => 'registered', 'icon' => 'person', 'color' => 'var(--color-text)', 'tooltip' => 'Registriert'],
        ];

        // if permissions array includes
        if (in_array('system.super-admin', $this->getPermissions($model))) return $visual['super-admin'];
        if (in_array('system.admin', $this->getPermissions($model))) return $visual['admin'];
        return $visual['registered'];
    }



    private function getMetadata($model)
    {
        return [
            'texts' => [
                $model->email ?? 'Email unbekannt'
            ],
            'icons' => [
                ['id' => 'email', 'icon' => 'mail', 'tooltip' => 'Email Bestätigung', 'color' => $model->email_verified_at ? 'var(--color-success)' : 'var(--color-text)'],
                ['id' => 'enabled', 'icon' => 'check_circle', 'tooltip' => 'Freigabe', 'color' => $model->is_enabled ? 'var(--color-success)' : 'var(--color-text)'],
                ['id' => 'customer', 'icon' => 'shopping_cart', 'tooltip' => 'Kunden-Profil', 'color' => $model->profiles['customer'] ? 'var(--color-info)' : 'var(--color-text)'],
                ['id' => 'employee', 'icon' => 'work', 'tooltip' => 'Mitarbeiter-Profil', 'color' => $model->profiles['employee'] ? 'var(--color-info)' : 'var(--color-text)'],
            ],
        ];
    }



    private function getActions($model)
    {
        return [
            [
                ['id' => 'open', 'icon' => 'visibility', 'tooltip' => 'Details', 'color' => 'var(--color-text)', 'action' => 'open'],
                ['id' => 'duplicate', 'icon' => 'content_copy', 'tooltip' => 'Duplizieren', 'color' => 'var(--color-text)', 'action' => 'duplicate'],
            ],
            [
                ['id' => 'delete', 'icon' => 'delete', 'tooltip' => 'Löschen', 'color' => 'var(--color-error)', 'action' => 'delete'],
            ]
        ];
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
            'email' => $this->email,
            // 'email_verified_at' => $this->email_verified_at,
            'image' => '/images/app/defaults/user.png',
            'roles' => $this->roles,
            'permissions' => $this->getPermissions($this),
            'displayVisual' => $this->getVisual($this),
            'displayMetadata' => $this->getMetadata($this),
            'displayActions' => $this->getActions($this),
            'settings' => $this->settings,
            'settings_object' => $this->settings_object,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}
