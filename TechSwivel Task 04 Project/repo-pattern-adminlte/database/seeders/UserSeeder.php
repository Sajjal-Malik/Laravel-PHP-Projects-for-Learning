<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

            $company = Company::first();

            
            User::create([
                'firstName' => 'Super',
                'lastName' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin12345'),
                'role' => User::ROLE_ADMIN,
                'isBlocked' => User::UNBLOCKED,
                'companyId' => null,
            ]);

            
            User::factory()->count(10)->create([
                'companyId' => $company?->id,
                'role' => User::ROLE_USER,
                'isBlocked' => User::UNBLOCKED,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("User Seeder Failed: " . $e->getMessage());
        }
    }
}
