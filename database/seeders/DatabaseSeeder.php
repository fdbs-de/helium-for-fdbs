<?php

namespace Database\Seeders;

use App\Models\User;
use App\Permissions\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Set up all roles and permissions
        Artisan::call('setup:roles');



        $root = User::create([
            'name' => 'Root',
            'email' => config('app.root_email'),
            'password' => Hash::make(config('app.root_password')),
        ]);

        $root->syncRoles([Roles::SUPER_ADMIN]);
        $root->email_verified_at = now();
        $root->enabled_at = now();
        $root->save();
    }
}
