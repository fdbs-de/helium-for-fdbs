<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SetupRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the roles for the application';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $permissions = config('role.permissions');

        foreach ($permissions as $id => $name)
        {
            $permission = Permission::firstOrCreate(['id' => $id], ['name' => $name]);

            $permission->id = $id;
            $permission->name = $name;
            $permission->save();
        }



        $roles = config('role.roles');

        foreach ($roles as $id => $item)
        {
            $role = Role::firstOrCreate(['id' => $id], ['name' => $item['name']]);

            $role->id = $id;
            $role->name = $item['name'];
            $role->save();

            $role->syncPermissions($item['permissions']);
        }

        return $this->info('Role setup successful.');
    }
}
