<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Permissions\Permissions;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {name} {--email=} {--username=} {--password=} {--su} {--active}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = new User();

        // Basic user info
        $user->name = $this->argument('name');
        $user->email = $this->option('email') ?? $this->ask('Email');
        $user->username = $this->option('username') ?? $this->ask('Username');



        // Select a password
        $password = $this->option('password') ?? $this->secret('Password');

        if (empty($password))
        {
            $password = Str::random(20);
        }

        $user->password = Hash::make($password);



        // Elevate to Super Admin
        if ($this->option('su'))
        {
            $user->givePermissionTo(Permissions::SYSTEM_SUPER_ADMIN);
        }



        // Activate the user
        if ($this->option('active'))
        {
            $user->enabled_at = now();
            $user->email_verified_at = now();
        }



        // Save the user
        $user->save();



        // Display the user info
        $output = "User created successfully!\n\n";

        $output .= "Name:      $user->name\n";
        $output .= "Email:     $user->email\n";
        $output .= "Username:  $user->username\n";
        $output .= "Password:  $password\n";
        $output .= "Status:    " . ($user->hasPermissionTo(Permissions::SYSTEM_SUPER_ADMIN) ? 'Super Admin' : 'User');

        return $this->info($output);
    }
}
