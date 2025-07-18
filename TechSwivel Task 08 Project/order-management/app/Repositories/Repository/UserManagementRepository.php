<?php

namespace App\Repositories\Repository;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\UserManagementRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Kreait\Laravel\Firebase\Facades\Firebase;

class UserManagementRepository implements UserManagementRepositoryInterface
{
    /**
     * Index list of All Riders
     * @return array|collection
     */
    public function getAllRiders()
    {
        try {
            return User::where('role', User::RIDER)->get();
        } catch (Exception $e) {

            throw new Exception('Failed to Load Riders ' . $e->getMessage());
        }
    }

    /**
     * Creates a Rider
     * @return User|Model
     */
    public function storeRider(array $data)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
                'role'     => User::RIDER,
            ]);

            DB::commit();

            return $user;
        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Failed to create Rider: ' . $e->getMessage());

            throw new Exception('Failed to create Rider ' . $e->getMessage());
        }
    }

    /**
     * Index list of All Customers
     * @return array|Collection
     */
    public function getAllCustomers()
    {
        try {
            return User::where('role', User::CUSTOMER)->get();
        } catch (Exception $e) {

            throw new Exception('Failed to Load Customers ' . $e->getMessage());
        }
    }

    /**
     * Create a Customer
     * @return User|Model
     */
    public function storeCustomer(array $data)
    {
        try {
            DB::beginTransaction();
            
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => bcrypt($data['password']),
                'role'     => User::CUSTOMER,
                'riderId'  => $data['riderId'],
            ]);

            DB::commit();

            return $user;
        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Failed to create Customer: ' . $e->getMessage());

            throw new Exception('Failed to create Customer' . $e->getMessage());
        }
    }

    /**
     * Register New User for (Rider or Customer)
     * @return array&&token
     */
    public function register(array $data)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'riderId' => $data['riderId'] ?? null
            ]);

            $firebaseAuth = Firebase::auth();

            $firebaseAuth->createUser([
                'displayName'  => $data['name'],
                'email'        => $data['email'],
                'password'     => $data['password'],
            ]);

            $token = $user->createToken('registerToken')->plainTextToken;

            DB::commit();

            return ['user' => $user, 'token' => $token];
        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Failed to Register ' . $e->getMessage());

            throw new Exception('User Registration Failed ' . $e->getMessage());
        }
    }

    /**
     * Perform Authentication for User
     * @return array&&token
     */
    public function login(array $credentials)
    {
        try {
            if (!Auth::attempt($credentials)) {
                return null;
            }

            $user = User::where('email', $credentials['email'])->firstOrFail();

            if (!$user || !Hash::check($credentials['password'], $user->password)) {
                return null;
            }

            $token = $user->createToken('loginToken')->plainTextToken;

            return ['user' => $user, 'token' => $token];
        } catch (Exception $e) {

            Log::error('User Login Failed ' . $e->getMessage());

            throw new Exception('User Login Failed ' . $e->getMessage());
        }
    }

    /**
     * Update the Credentails of Logged in User
     * @return array|User|Collection|Model
     */
    public function updateProfile(array $data)
    {
        try{
            DB::beginTransaction();

            $authUser = Auth::user();
            
            $user = User::findOrFail($authUser->id);

            $user->name = $data['name'];
            $user->email = $data['email'];

            if(!empty($data['password'])){
                $user->password = Hash::make($data['password']);
            }

            $user->save();

            DB::commit();

            return $user;
        }
        catch(Exception $e){

            DB::rollBack();

            Log::error('Profile update Failed ' . $e->getMessage());

            throw new Exception('Failed to update Profile ' . $e->getMessage());
        }
    }
}
