<?php

namespace App\Models;

use App\Permissions\Permissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'email_verified_at',
        'enabled_at',
    ];

    protected $appends = [
        'settings_object',
        'is_enabled',
        'profiles',
        'access',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'enabled_at' => 'datetime',
    ];



    public function getIsEnabledAttribute()
    {
        return $this->enabled_at !== null && $this->enabled_at < now();
    }



    public function getImageAttribute()
    {
        return $this->image ?? '/images/app/defaults/user.png';
    }



    // START: Settings
    public function settings()
    {
        return $this->hasMany(UserSetting::class);
    }

    public function hasSetting($key)
    {
        return $this->settings()->where('key', $key)->exists();
    }

    public function setSetting($key, $value)
    {
        $this->settings()->updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public function unsetSetting($key)
    {
        $this->settings()->where('key', $key)->delete();
    }

    public function getSetting($key)
    {
        if (!$this->hasSetting($key)) return null;
        return $this->settings()->firstWhere('key', $key)->value;
    }

    public function getSettingsObjectAttribute()
    {
        $settings = $this->settings->mapWithKeys(function ($item) {
            return [$item['key'] => $item['value']];
        });

        return $settings;
    }
    // END: Settings



    // START: Posts
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_user')->withPivot('role');
    }
    // END: Posts



    // START: Profiles
    public function getProfilesAttribute()
    {
        $profiles = [];
        
        $profiles['customer'] = $this->getSetting('profile.customer');
        $profiles['employee'] = $this->getSetting('profile.employee');

        return $profiles;
    }
    // END: Profiles



    // START: Roles
    /**
     * Get all role ids that user has been assigned
     * 
     * @return array
     */
    public function getRoleIdsAttribute()
    {
        return $this->roles()->pluck('id')->toArray();
    }

    /**
     * Get all role ids that user has access to
     * This may include role ids that user does not have been assigned
     * 
     * @return array
     */
    public function getAccessableRoleIdsAttribute()
    {
        if ($this->can(Permissions::SYSTEM_ADMIN))
        {
            return Role::get()->pluck('id')->toArray();
        }

        return $this->role_ids;
    }
    // END: Roles



    private function hasAdminLikePermission()
    {
        return User::find($this->id)->can(Permissions::CAN_ACCESS_ADMIN_PANEL);
    }

    public function getCanAccessAdminPanelAttribute()
    {
        if (!$this->is_enabled) return false;
        if ($this->hasAdminLikePermission()) return true;
        
        return false;
    }

    public function getCanAccessEmployeePanelAttribute()
    {
        if (!$this->is_enabled) return false;
        if (!!$this->profiles['employee']) return true;
        if ($this->hasAdminLikePermission()) return true;

        return false;
    }
    
    public function getCanAccessCustomerPanelAttribute()
    {
        if (!$this->is_enabled) return false;
        if (!!$this->profiles['employee']) return true;
        if (!!$this->profiles['customer']) return true;
        if ($this->hasAdminLikePermission()) return true;

        return false;
    }

    public function getAccessAttribute()
    {
        return [
            'admin'     => $this->is_enabled && ($this->hasAdminLikePermission()),
            'employee'  => $this->is_enabled && ($this->hasAdminLikePermission() || !!$this->profiles['employee']),
            'customer'  => $this->is_enabled && ($this->hasAdminLikePermission() || !!$this->profiles['employee'] || !!$this->profiles['customer']),
        ];
    }



    /**
     * Get the user's best fitting name.
     * @return string|null
     */
    public function getDisplayNameAttribute()
    {
        $customerProfile = $this->getSetting('profile.customer');
        if ($customerProfile) return $customerProfile['company'];

        $employeeProfile = $this->getSetting('profile.employee');
        if ($employeeProfile) return $employeeProfile['first_name'] . ' ' . $employeeProfile['last_name'];

        return null;
    }

    public function updateName()
    {
        $this->name = $this->display_name;
        $this->save();
    }
}
