<?php

namespace App\Providers;

use App\Permissions\Permissions;
use App\Permissions\Roles;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Bestätigen Sie Ihre Email-Adresse')
                ->markdown('emails.VerifyMail', ['url' => $url]);
        });



        // Super Admin Gate
        Gate::after(function ($user, $ability) {
            return $user->permissions()->firstWhere('name', Permissions::SYSTEM_SUPER_ADMIN) ? true : null;
        });
    }
}
