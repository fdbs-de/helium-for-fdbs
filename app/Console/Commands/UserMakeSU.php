<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Permissions\Permissions;
use Illuminate\Console\Command;

class UserMakeSU extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-su {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gives users Super Admin permission';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::find($this->argument('user'));
        $user->givePermissionTo(Permissions::SYSTEM_SUPER_ADMIN);

        return $this->info("Name:   $user->name\nEmail:  $user->email\nStatus: Super Admin permission granted");
    }
}
