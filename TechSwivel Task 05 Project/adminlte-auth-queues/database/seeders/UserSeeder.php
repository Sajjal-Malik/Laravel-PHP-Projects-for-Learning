<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {

            DB::beginTransaction();

            User::create([
                'firstName' => 'Super',
                'lastName'  => 'Admin',
                'userName'  => 'admin',
                'email'     => 'admin@example.com',
                'password'  => bcrypt('admin1234'),
                'role'      => 1,
                'status'    => 'Active',
            ]);

            Company::all()->each(function ($company) {
                User::factory()->count(10)
                    ->create(['companyId' => $company->id]);
            });

            DB::commit();
            
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error("User Seeder Failed: " . $e->getMessage());
        }
    }
}
