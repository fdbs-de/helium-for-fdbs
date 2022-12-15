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
        'display_name',
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



    /**
     * Get the customer profile record associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customerProfile()
    {
        return $this->hasOne(CustomerProfile::class);
    }

    /**
     * Get the employee profile record associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employeeProfile()
    {
        return $this->hasOne(EmployeeProfile::class);
    }



    public function getIsEnabledAttribute()
    {
        return $this->enabled_at !== null && $this->enabled_at < now();
    }

    public function getIsEnabledCustomerAttribute()
    {
        return $this->customerProfile && $this->customerProfile->enabled_at !== null && $this->customerProfile->enabled_at < now();
    }

    public function getIsEnabledEmployeeAttribute()
    {
        return $this->employeeProfile && $this->employeeProfile->enabled_at !== null && $this->employeeProfile->enabled_at < now();
    }



    public function getCanAccessAdminPanelAttribute()
    {
        return $this->is_enabled && User::find($this->id)->can(Permissions::CAN_ACCESS_ADMIN_PANEL);
    }

    public function getCanAccessCustomerPanelAttribute()
    {
        return $this->is_enabled && (User::find($this->id)->can(Permissions::CAN_ACCESS_ADMIN_PANEL) || $this->is_enabled_customer || $this->is_enabled_employee);
    }

    public function getCanAccessEmployeePanelAttribute()
    {
        return $this->is_enabled && (User::find($this->id)->can(Permissions::CAN_ACCESS_ADMIN_PANEL) || $this->is_enabled_employee);
    }



    public function getDisplayNameAttribute()
    {
        // This should either return the company name or the user's name or null
        return $this->customerProfile ? $this->customerProfile->company : ($this->employeeProfile ? $this->employeeProfile->first_name . ' ' . $this->employeeProfile->last_name : null);
    }
}
