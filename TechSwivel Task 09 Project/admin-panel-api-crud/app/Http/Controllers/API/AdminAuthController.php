<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AdminLoginRequest;
use App\Http\Resources\Resource\Admin\AdminAuthResource;
use App\Repositories\Interfaces\API\AdminAuthRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;

class AdminAuthController extends Controller
{
    public function __construct(protected AdminAuthRepositoryInterface $adminAuthRepo)
    {
        //
    }
    /**
     * Login the Admin User
     * @return JsonResponse
     */
    public function signin(AdminLoginRequest $adminLoginRequest)
    {
        try{

            $authData = $this->adminAuthRepo->login($adminLoginRequest->all());

            return response()->json([
                'success' => true,
                'message' => "Login Successful",
                'user' => new AdminAuthResource($authData['user']),
                'token' => $authData['token']
            ], JsonResponse::HTTP_OK);
        }
        catch(Exception $e){

            return response()->json([
                'error' => true,
                'message' => "Login Attempt Failed",
                'detail' => $e->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * logout the Admin User
     * @return JsonResponse
     */
    public function signout()
    {
        try{       
            $this->adminAuthRepo->logout();

            return response()->json([
                'success' => true,
                'message' => "Logout Successful",
            ], JsonResponse::HTTP_OK);
        }
        catch(Exception $e){

            return response()->json([
                'error' => true,
                'message' => "Logout Attempt Failed",
                'detail' => $e->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
