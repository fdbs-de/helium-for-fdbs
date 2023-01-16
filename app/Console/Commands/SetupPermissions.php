<?php

namespace App\Console\Commands;

use App\Permissions\Permissions;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class SetupPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup permissions for the application';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $permissions = Permissions::getPermissionsList();
        $createCount = 0;
        $updateCount = 0;

        foreach ($permissions as $permission)
        {
            Permission::where('name', $permission)->exists() ? $updateCount++ : $createCount++;
            Permission::updateOrCreate(['name' => $permission]);
        }

        return $this->info("Permission setup successful!\nCreated: {$createCount}\nUpdated: {$updateCount}");
    }
}
