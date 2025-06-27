<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:create {name}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new database dynamically';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dbName = $this->argument('name');

        try{

            $query = "CREATE DATABASE IF NOT EXISTS `$dbName`";
            
            DB::statement($query);

            $this->info("Database '$dbName' Created Successfully.");

            return Command::SUCCESS;
        }
        catch(\Exception $e){

            $this->error('Error creating database '. $e->getMessage());

            return Command::FAILURE;
        }
    }
}
