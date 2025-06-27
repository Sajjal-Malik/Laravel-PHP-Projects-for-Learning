<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DumpDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:dump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all Tables and Reseed the Database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try{
            $this->info('Resetting database...');

            $this->call('migrate:fresh', ['--seed' => true]);

            $this->info('Database has been freshly Migrated and Seeded.');

            return Command::SUCCESS;
        }
        catch(\Exception $e){

            $this->error('DB Dump Command Failed' . $e->getMessage());

            return Command::FAILURE;
        }
    }
}
