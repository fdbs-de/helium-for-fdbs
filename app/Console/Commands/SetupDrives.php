<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class SetupDrives extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:drives';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup internal storage drives for the application';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controller = new \App\Http\Controllers\Dashboard\MediaController();
        $controller->setupMediaDrives();

        $this->info('Media drives have been setup successfully!');
    }
}
