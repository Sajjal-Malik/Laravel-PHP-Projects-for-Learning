<?php

namespace App\Repositories\Repository;

use App\Actions\Fortify\CreateNewUser;
use App\Jobs\SendUserEmailJob;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserRepository implements UserRepositoryInterface
{
    use FileUploadTrait;

    public function all()
    {
        try {
            return User::all();
        } catch (Exception $e) {
            throw new Exception('Failed to retrieve users: ' . $e->getMessage());
        }
    }

    public function find($id)
    {
        try {
            return User::findOrFail($id);
        } catch (Exception $e) {
            throw new Exception('User not found: ' . $e->getMessage());
        }
    }

    public function store(array $data)
    {
        try {
            DB::beginTransaction();

            $newUser = new CreateNewUser();

            $user = $newUser->create([
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'userName' => $data['userName'],
                'email' => $data['email'],
                'companyId'  => $data['companyId'] ?? null,
                'phone'      => $data['phone'] ?? null,
                'password' => $data['password'],
                'password_confirmation' => $data['password_confirmation'] ?? $data['password'],
            ]);

            if (isset($data['empPhoto'])) {
                $user->empPhoto = $this->uploadPhoto($data['empPhoto']);
                $user->save();
            }

            DB::commit();

            dispatch(new SendUserEmailJob($user));

            return $user;
            
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Failed to create user: ' . $e->getMessage());
        }
    }

    public function toggleBlock($id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $user->status = $user->status === 'Blocked' ? 'Active' : 'Blocked';
            $user->save();

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Failed to toggle user status: ' . $e->getMessage());
        }
    }

    public function getEmployees()
    {
        try {
            return User::where('role', 2)->all();
        } catch (Exception $e) {
            throw new Exception('Failed to retrieve employees: ' . $e->getMessage());
        }
    }

    public function storeEmployee(array $data)
    {
        try {
            DB::beginTransaction();

            $data['role'] = 2;
            $data['password'] = $data['password'] ?? 'password';
            $data['password_confirmation'] = $data['password_confirmation'] ?? $data['password'];
            $user = $this->store($data);

            DB::commit();

            dispatch(new SendUserEmailJob($user));

            return $user;
        } catch (Exception $e) {

            DB::rollBack();

            throw new Exception('Failed to save employee: ' . $e->getMessage());
        }
    }

    public function updateEmployee($id, array $data)
    {
        try {

            DB::beginTransaction();

            $user = User::where('role', 2)->findOrFail($id);

            if (isset($data['empPhoto'])) {
                $data['empPhoto'] = $this->uploadPhoto($data['empPhoto']);
            }

            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user->update($data);
            DB::commit();
            return $user;
        } catch (Exception $e) {

            DB::rollBack();

            throw new Exception('Failed to update employee: ' . $e->getMessage());
        }
    }

    public function deleteEmployee($id)
    {

        try {
            return User::where('role', 2)->where('id', $id)->delete();
        } catch (Exception $e) {

            throw new Exception('Failed to delete employee: ' . $e->getMessage());
        }
    }
}
