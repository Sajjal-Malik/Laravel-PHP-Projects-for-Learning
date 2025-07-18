<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\UserManagementRepositoryInterface;
use Exception;

class AuthApiController extends Controller
{
    protected $userRepo;
    public function __construct(UserManagementRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    /**
     * Create User Account (Rider or Customer)
     * @return mixed|JsonResponse
     */
    public function signup(SignupRequest $signupRrequest)
    {
        try {
            $data = $this->userRepo->register($signupRrequest->all());

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
     * Attemp to Login for Specified User
     * @return mixed|JsonResponse
     */
    public function signin(SigninRequest $signinRequest)
    {
        try {
            $data = $this->userRepo->login($signinRequest->only(['email', 'password']));

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
     * Update User Profile Credentials
     * @return mixed|JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $user = $this->userRepo->updateProfile($request->all());

            return response()->json([
                'messsage' => 'Profile Updated Successfully',
                'user' => $user,
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'error' => true,
                'message' => 'Failed to update profile',
                'detail' => $e->getMessage()
            ], 400);
        }
    }
}
