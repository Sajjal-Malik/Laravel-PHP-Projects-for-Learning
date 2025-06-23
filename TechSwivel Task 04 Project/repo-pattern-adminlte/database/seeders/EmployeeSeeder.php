<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        try {

            $company = Company::first();

            Employee::factory()->count(2)->create([
                'companyId' => $company->id,
                'empPhoto' => null,
            ]);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error("Employee Seeder Failed: " . $e->getMessage());
        }
    }
}
