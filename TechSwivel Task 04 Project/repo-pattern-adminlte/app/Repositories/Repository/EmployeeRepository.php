<?php

namespace App\Repositories\Eloquent;

use App\Mail\EmployeeCreatedMail;
use App\Models\Employee;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmployeeRepository implements EmployeeRepositoryInterface
{

    use FileUploadTrait;
    public function all()
    {
        try {
            return Employee::with('company')->select('employees.*');
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function store(array $data)
    {

        try {
            DB::beginTransaction();
            
            if (isset($data['empPhoto'])) {

                $data['empPhoto'] = $this->uploadPhoto($data['empPhoto']);
            }

            $employee = Employee::create($data);

            Mail::to('admin@example.com')->send(new EmployeeCreatedMail($employee));
            
            DB::commit();

            return $employee;
        } catch (\Throwable $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public function find($id)
    {
        try {
            return Employee::with('company')->findOrFail($id);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function update($id, array $data)
    {

        try {
            DB::beginTransaction();

            $employee = Employee::findOrFail($id);

            if (isset($data['empPhoto'])) {

                $this->deletePhoto($employee->empPhoto);

                $data['empPhoto'] = $this->uploadPhoto($data['empPhoto']);
            }

            $employee->update($data);

            DB::commit();

            return $employee;
        } catch (\Throwable $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public function delete($id)
    {
        try {
            return Employee::destroy($id);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
}
