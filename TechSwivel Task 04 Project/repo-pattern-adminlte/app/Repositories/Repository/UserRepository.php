<?php

namespace App\Repositories\Repository;

use App\Actions\Fortify\CreateNewUser;
use App\Events\UserCreated;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{
    use FileUploadTrait;

    public function all()
    {
        try {
            return User::select([
                'id',
                'firstName',
                'lastName',
                'email',
                'role',
                'isBlocked',
                'companyId',
                'empPhoto'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function find($id)
    {
        try {
            return User::findOrFail($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(array $data)
    {
        try {
            DB::beginTransaction();

            $newUser = new CreateNewUser();

            Log::info('Incoming data to CreateNewUser', $data);

            $user = $newUser->create([
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'email' => $data['email'],
                'password' => $data['password'],
                'password_confirmation' => $data['password_confirmation'],
            ]);

            event(new UserCreated($user));

            DB::commit();

            return $user;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function toggleBlock($id)
    {
        try {
            $user = $this->find($id);
            $user->isBlocked = !$user->isBlocked;
            $user->save();

            return $user;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getEmployees()
    {
        try {
            return User::with('company')
                ->where('role', User::ROLE_USER)
                ->select('users.*')
                ->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function storeEmployee(array $data)
    {
        try {
            DB::beginTransaction();

            if (isset($data['empPhoto'])) {
                $data['empPhoto'] = $this->uploadPhoto($data['empPhoto']);
            }

            $data['role'] = User::ROLE_USER;
            $data['isBlocked'] = User::UNBLOCKED;
            $data['password'] = Hash::make('password');

            $employee = User::create($data);

            event(new UserCreated($employee));

            DB::commit();

            return $employee;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateEmployee($id, array $data)
    {
        try {
            DB::beginTransaction();

            $employee = User::findOrFail($id);

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

    public function deleteEmployee($id)
    {
        try {
            return User::destroy($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
