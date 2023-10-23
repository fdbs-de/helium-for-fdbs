<?php

namespace App\Models;

use App\Permissions\Permissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'image',
        'email',
        'username',
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

    public function hasProfile($profile)
    {
        return !!$this->profiles[$profile];
    }

    public function hasAnyProfile($profiles)
    {
        foreach ($profiles as $profile)
        {
            if ($this->hasProfile($profile)) return true;
        }

        return false;
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

    public function availableRoles()
    {
        if ($this->can(Permissions::SYSTEM_ADMIN))
        {
            return Role::select('*');
        }

        return $this->roles();
    }

    /**
     * Get all role ids that user has access to
     * This may include roles user has not been assigned with
     * 
     * @return array
     */
    public function getAvailableRoleIdsAttribute()
    {
        if ($this->can(Permissions::SYSTEM_ADMIN))
        {
            return Role::get()->pluck('id')->toArray();
        }

        return $this->role_ids;
    }
    // END: Roles



    private function hasAdminPanelAccess()
    {
        return User::find($this->id)->can(Permissions::SYSTEM_ACCESS_ADMIN_PANEL);
    }

    public function getAccessAttribute()
    {
        return [
            'admin'     => $this->is_enabled && ($this->hasAdminPanelAccess()),
            'employee'  => $this->is_enabled && ($this->hasAdminPanelAccess() || !!$this->profiles['employee']),
            'customer'  => $this->is_enabled && ($this->hasAdminPanelAccess() || !!$this->profiles['employee'] || !!$this->profiles['customer']),
        ];
    }



    public function getIsAdminAttribute()
    {
        return User::find($this->id)->canAny([Permissions::SYSTEM_ADMIN, Permissions::SYSTEM_SUPER_ADMIN]);
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



    public function duplicate()
    {
        $user = $this->replicate()->fill([
            'email' => null,
            'username' => null,
            'email_verified_at' => null,
            'enabled_at' => null,
        ]);

        $user->push();
        
        $settings = $this->settings;

        foreach ($settings as $setting)
        {
            $user->settings()->create([
                'key' => $setting->key,
                'value' => $setting->value,
            ]);
        }

        return $user;
    }
}
