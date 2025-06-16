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

            if (!$company) {
                throw new \Exception("No company found. Run CompanySeeder first.");
            }


            Employee::create([
                'firstName' => 'Sajjal',
                'lastName' => 'Malik',
                'companyId' => $company->id,
                'email' => 'sajjalmalik@evilcorp.com',
                'phone' => '1234567890',
            ]);

            Employee::create([
                'firstName' => 'Duraid',
                'lastName' => 'Malik',
                'companyId' => $company->id,
                'email' => 'duraidmalik@evilcorp.com',
                'phone' => '9876543210',
            ]);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Employee Seeder Failed: ' . $e->getMessage());
        }
    }
}
