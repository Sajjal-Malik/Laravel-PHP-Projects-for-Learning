<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminSeeder extends Seeder
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
                'lastName' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin1234'),
                'avatar' => null,
                'role' => 1,
            ]);

            DB::commit();
            
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error("Admin Seeder Failed: " . $e->getMessage());
        }
    }
}
