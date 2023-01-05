<?php

namespace App\Models;

use App\Permissions\Permissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'enabled_at',
    ];

    protected $appends = [
        'settings_object',
        'is_enabled',
        'profiles',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'enabled_at' => 'datetime',
    ];



    public function customerProfile()
    {
        return $this->hasOne(CustomerProfile::class);
    }

    public function employeeProfile()
    {
        return $this->hasOne(EmployeeProfile::class);
    }

    public function settings()
    {
        return $this->hasMany(UserSetting::class);
    }



    public function getProfilesAttribute()
    {
        $profiles = [];
        
        $profiles['customer'] = $this->getSetting('profile.customer');
        $profiles['employee'] = $this->getSetting('profile.employee');

        return $profiles;
    }



    public function getSettingsObjectAttribute()
    {
        $settings = $this->settings->mapWithKeys(function ($item) {
            return [$item['key'] => $item['value']];
        });

        return $settings;
    }



    public function getIsEnabledAttribute()
    {
        return $this->enabled_at !== null && $this->enabled_at < now();
    }



    public function getCanAccessAdminPanelAttribute()
    {
        return $this->is_enabled && User::find($this->id)->can(Permissions::CAN_ACCESS_ADMIN_PANEL);
    }

    public function getCanAccessCustomerPanelAttribute()
    {
        return $this->is_enabled && (User::find($this->id)->can(Permissions::CAN_ACCESS_ADMIN_PANEL) || !!$this->customerProfile || !!$this->employeeProfile);
    }

    public function getCanAccessEmployeePanelAttribute()
    {
        return $this->is_enabled && (User::find($this->id)->can(Permissions::CAN_ACCESS_ADMIN_PANEL) || !!$this->employeeProfile);
    }



    /**
     * Get the user's best fitting name.
     * @return string|null
     */
    public function getDisplayNameAttribute()
    {
        $customerProfile = $this->getSetting('profile.customer');
        if ($customerProfile)
        {
            return $customerProfile['company'];
        }

        $employeeProfile = $this->getSetting('profile.employee');
        if ($employeeProfile)
        {
            return $employeeProfile['first_name'] . ' ' . $employeeProfile['last_name'];
        }

        return null;
    }



    public function setSetting($key, $value)
    {
        $this->settings()->updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public function getSetting($key)
    {
        return $this->settings()->firstWhere('key', $key)->value ?? null;
    }



    public function updateName()
    {
        $this->name = $this->display_name;
        $this->save();
    }
}
