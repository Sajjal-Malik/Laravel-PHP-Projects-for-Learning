<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        DB::beginTransaction();

        try {

            User::create([
                'name' => 'User One',
                'email' => 'user1@example.com',
                'password' => Hash::make('password1'),
                'role' => User::ROLE_USER,
                'isActive' => 1,
            ]);

            User::create([
                'name' => 'User Two',
                'email' => 'user2@example.com',
                'password' => Hash::make('password2'),
                'role' => User::ROLE_USER,
                'isActive' => 0,
            ]);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error("Company Seeder Failed: " . $e->getMessage());
        }
    }
}
