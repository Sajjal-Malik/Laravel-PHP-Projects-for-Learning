<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Exception;

class AuthController extends Controller
{
    protected $authRepo;

    public function __construct(AuthRepositoryInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    /**
     * Validate Data using Form Request and Register or Create a User
     * @return JsonResponse
     */
    public function register(RegisterRequest $registerRequest)
    {
        try {
            $data = $this->authRepo->register($registerRequest->all());

            return response()->json([
                'user' => new UserResource($data['user']),
                'token' => $data['token']
            ], 201);
        } catch (Exception $e) {

            return response()->json([
                'error' => true,
                'message' => 'User Registration Failed',
                'detail' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Validate data using Form Request and Login User
     * @return JsonResponse
     */
    public function login(LoginRequest $loginRequest)
    {
        try {
            $data = $this->authRepo->login($loginRequest->only(['email', 'password']));

            if (!$data) {
                return response()->json(['error' => true, 'message' => 'Invalid Credentials'], 401);
            }

            return response()->json([
                'user' => new UserResource($data['user']),
                'token' => $data['token']
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'error' => true,
                'message' => 'User Login Failed',
                'detail' => $e->getMessage()
            ], 401);
        }
    }

    /**
     * Get Profile of the Current User from Resource
     * @return JsonResponse
     */
    public function profile()
    {
        try {
            $user = $this->authRepo->getProfile();

            if (!$user) {
                throw new Exception('Unauthenticated');
            }

            return response()->json([
                'user' => new UserResource($user)
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'error' => true,
                'message' => 'Unauthenticated',
                'detail' => $e->getMessage()
            ], 401);
        }
    }

    /**
     * Validate Data and Send Token for Password Reset
     * @return JsonResponse
     */
    public function forgetPassword(PasswordRequest $request)
    {
        try {
            $this->authRepo->sendResetToken($request->only('email'));

            return response()->json(['message' => 'Reset token sent successfully'], 200);

        } catch (Exception $e) {

            return response()->json([
                'error'   => true,
                'message' => 'Reset token failed',
                'detail'  => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate data and Verify Token for Password Reset
     * @return JsonResponse
     */
    public function verifyResetToken(PasswordRequest $request)
    {
        try {
            $this->authRepo->verifyResetToken($request->only('email', 'token'));

            return response()->json(['message' => 'Token verified'], 200);
            
        } catch (Exception $e) {

            return response()->json([
                'error'   => true,
                'message' => 'Token verification failed',
                'detail'  => $e->getMessage()
            ], 401);
        }
    }

    /**
     * Validate data and Make Password Reset Successfull
     * @return JsonResponse
     */
    public function resetPassword(PasswordRequest $request)
    {
        try {
            $this->authRepo->resetPassword($request->only('email', 'token', 'password'));
            
            return response()->json(['message' => 'Password reset successful'], 200);

        } catch (Exception $e) {

            return response()->json([
                'error'   => true,
                'message' => 'Password reset failed',
                'detail'  => $e->getMessage()
            ], 401);
        }
    }
}
