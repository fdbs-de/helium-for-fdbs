<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\EmailVerifiedNotification;
use App\Permissions\Permissions;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendEmailVerifiedNotification
{
    public function handle($event)
    {
        // TODO: get all admins including super admins
        $admins = User::permission(Permissions::SYSTEM_ADMIN)->get();

        Notification::send($admins, new EmailVerifiedNotification($event->user));
    }
}
