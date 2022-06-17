<?php

namespace Database\Seeders;

use App\Models\User;
use App\Permissions\Permissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user = User::create([
            'name' => 'Root',
            'email' => config('app.root_email'),
            'password' => Hash::make(config('app.root_password')),
        ]);

        $user->update([
            'email_verified_at' => now(),
            'enabled_at' => now(),
        ]);

        $super_admin_role = Role::create(['name' => 'super admin']);
        $admin_role = Role::create(['name' => 'admin']);
        $editor_role = Role::create(['name' => 'editor']);

        $ACCESS_ADMIN_PANEL = Permission::create(['name' => Permissions::CAN_ACCESS_ADMIN_PANEL]);
        $EDIT_JOB_OFFERS = Permission::create(['name' => Permissions::CAN_EDIT_JOB_OFFERS]);
        $EDIT_USERS = Permission::create(['name' => Permissions::CAN_EDIT_USERS]);

        $super_admin_role->givePermissionTo($ACCESS_ADMIN_PANEL);
        $super_admin_role->givePermissionTo($EDIT_JOB_OFFERS);
        $super_admin_role->givePermissionTo($EDIT_USERS);

        $admin_role->givePermissionTo($ACCESS_ADMIN_PANEL);
        $admin_role->givePermissionTo($EDIT_JOB_OFFERS);
        $admin_role->givePermissionTo($EDIT_USERS);

        $editor_role->givePermissionTo($ACCESS_ADMIN_PANEL);
        $editor_role->givePermissionTo($EDIT_JOB_OFFERS);

        $user->assignRole('super admin');
    }
}
