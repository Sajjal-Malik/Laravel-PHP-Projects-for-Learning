<?php

namespace App\Repositories\Repository\API;

use App\Models\User;
use App\Repositories\Interfaces\API\AdminAuthRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminAuthRepository implements AdminAuthRepositoryInterface
{
    /**
     * Login the Amin User
     * @return array
     */
    public function login(array $credentials)
    {
        try {
            $user = User::where('email', $credentials['email'])->first();

            if (!$user || !Hash::check($credentials['password'], $user->password)) {
                throw new Exception('Invalid credentials provided.');
            }

            if ($user->role !== User::ADMIN) {
                throw new Exception('Only admins can log in.');
            }

            $token = $user->createToken('AdminAuthToken')->plainTextToken;

            return [
                'user' => $user,
                'token' => $token,
            ];
        } catch (Exception $e) {

            Log::error("Admin Login Failed: " . $e->getMessage());

            throw new Exception("Login failed. Please try again: " . $e->getMessage());
        }
    }

    /**
     * Logout the Admin User
     * @return void
     */
    public function logout()
    {
        try {
            $user = auth()->user();

            return $user->currentAccessToken()?->delete();
            
        } catch (Exception $e) {

            Log::error("Admin Logout Failed: " . $e->getMessage());

            throw new Exception("Logout failed. Please try again: " . $e->getMessage());
        }
    }
}
