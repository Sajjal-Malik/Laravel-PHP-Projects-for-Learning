<?php

namespace App\Repositories\Eloquent;

use App\Actions\Fortify\CreateNewUser;
use App\Events\UserCreated;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        try{

            return User::select(['id', 'name', 'email', 'role', 'isBlocked']);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function find($id)
    {
        try{
            return User::findOrFail($id);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(array $data)
    {
        
        try {
            DB::beginTransaction();

            $newUser = new CreateNewUser();

            $user = $newUser->create([
                'name' => $data['name'],
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
        try{
            $user = $this->find($id);
            $user->isBlocked = !$user->isBlocked;
            $user->save();
    
            return $user;
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        
    }
}
