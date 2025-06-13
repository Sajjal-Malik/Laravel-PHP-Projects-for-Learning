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
                'firstName' => "Sajjal",
                'lastName' => "Malik",
                'email' => "sm@evilcorp.com",
                'password' => Hash::make('password123'),
                'age' => 24,
                'phoneNumber' => '123123123',
                'Bio' => 'This is a dummy Bio Text for this current User',
                'DOB' => '2000-01-01'
            ]);

            User::create([
                'firstName' => "Duraid",
                'lastName' => "Bhatti",
                'email' => "db@ismailcorp.com",
                'password' => Hash::make('123password'),
                'age' => 25,
                'phoneNumber' => '321321321',
                'Bio' => 'This is a dummy Text for Bio of this new User',
                'DOB' => '1999-02-02'
            ]);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error("Company Seeder Failed: " . $e->getMessage());

        }
    }
}
