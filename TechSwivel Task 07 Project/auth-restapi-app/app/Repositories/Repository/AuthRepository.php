<?php

namespace App\Repositories\Repository;

use App\Events\UserRegistered;
use App\Events\PasswordResetSuccess;
use App\Mail\PasswordResetTokenMail;
use App\Models\PasswordReset;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Str;

class AuthRepository implements AuthRepositoryInterface
{
    /**
     * Register or Create a User in Database and Firebase
     * @return array{token: string, user: User}
     */
    public function register(array $data)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'password_confirmation' => $data['password_confirmation'] ?? $data['password'],
                'avatar' => $data['avatar'] ?? null,
                'role' => 2,
            ]);

            $firebaseAuth = Firebase::auth();

            $firebaseAuth->createUser([
                'email'        => $data['email'],
                'password'     => $data['password'],
                'displayName'  => $data['firstName'] . ' ' . $data['lastName'],
                'photoUrl'     => $data['avatar'] ?? null,
            ]);

            event(new UserRegistered($user));

            $token = $user->createToken('registerToken')->plainTextToken;

            DB::commit();

            return ['user' => $user, 'token' => $token];
        } catch (Exception $e) {

            DB::rollBack();

            throw new Exception('User Registration Failed' . $e->getMessage());
        }
    }

    /**
     * Perform Login for the Authenticated User
     * @param array $credentials
     * @return array{token: string, user: User|null}
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

            throw new Exception('User Login Failed' . $e->getMessage());
        }
    }

    /**
     * Get Specific User Data from DB
     * @return User
     */
    public function getProfile()
    {
        try {
            return Auth::user();

        } catch (Exception $e) {

            throw new Exception('User not Found' . $e->getMessage());
        }
    }

    /**
     * Ensure Token Send for Verification of User
     * @param array $data
     * @return bool
     */
    public function sendResetToken(array $data)
    {
        try {
            DB::beginTransaction();

            $email = $data['email'];

            $user = User::where('email', $email)->first();

            if (!$user) {
                throw new Exception('User Not Found');
            }

            $token = Str::random(6);

            PasswordReset::updateOrCreate(
                ['email' => $email],
                ['token' => $token, 'createdAt' => now()]
            );

            Mail::to($email)->send(new PasswordResetTokenMail($token));

            DB::commit();

            return true;

        } catch (Exception $e) {

            DB::rollBack();

            throw new Exception('Sending Reset Token Failed ' . $e->getMessage());
        }
    }

    /**
     * Ensure verification of the Token and Expiration Time
     * @param array $data
     * @return bool
     */
    public function verifyResetToken(array $data)
    {
        try {
            $record = PasswordReset::where('email', $data['email'])->where('token', $data['token'])->first();

            if (!$record || Carbon::parse($record->createdAt)->addMinutes(10)->isPast()) {
                throw new Exception('Invalid or Expired token');
            }

            return true;
            
        } catch (Exception $e) {

            throw new Exception('Token verification Failed ' . $e->getMessage());
        }
    }

    /**
     * Ensure Password Reset Successfully in DB
     * @param array $data
     * @return bool
     */
    public function resetPassword(array $data)
    {
        try {
            DB::beginTransaction();

            $record = PasswordReset::where('email', $data['email'])->where('token', $data['token']);

            if (!$record) {
                throw new Exception('Invalid token');
            }

            $user = User::where('email', $data['email'])->first();
            $user->update(['password' => Hash::make($data['password'])]);

            PasswordReset::where('email', $data['email'])->delete();

            event(new PasswordResetSuccess($user));

            DB::commit();

            return true;

        } catch (Exception $e) {

            DB::rollBack();

            throw new Exception('Password Reset Failed ' . $e->getMessage());
        }
    }
}
