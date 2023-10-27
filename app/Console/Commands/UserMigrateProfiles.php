<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class UserMigrateProfiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:migrate-profiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate user profiles to new format';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $user)
        {
            // If user has no details row, create one
            if (!$user->details) $user->details()->create();

            $customer = $user->getSetting('profile.customer');
            $employee = $user->getSetting('profile.employee');

            if ($customer)
            {
                $user->update(['custom_account_id' => $customer['customer_id']]);
                $user->details()->update(['company' => $customer['company']]);
                $user->roles()->syncWithoutDetaching([Role::where('name', 'Kunde')->first()->id]);
            }

            if ($employee)
            {
                $user->details()->update([
                    'firstname' => $employee['first_name'],
                    'lastname' => $employee['last_name'],
                ]);
                $user->roles()->syncWithoutDetaching([Role::where('name', 'Personal')->first()->id]);
            }
        }

        return $this->info('Profiles migrated successfully');
    }
}
