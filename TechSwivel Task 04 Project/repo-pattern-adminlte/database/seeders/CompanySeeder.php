<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        try {

            Company::factory()->create([
                'name' => 'Tech Innovations',
                'email' => 'info@techinnovations.com',
                'website' => 'https://www.techinnovations.com',
                'logo' => null,
            ]);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error("Company Seeder Failed: " . $e->getMessage());
        }
    }
}
