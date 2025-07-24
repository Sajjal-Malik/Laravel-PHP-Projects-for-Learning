<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\ProfileApiRequest;
use App\Http\Resources\Collection\Profile\ProfileApiCollection;
use App\Http\Resources\Resource\Profile\ProfileApiResource;
use App\Models\User;
use App\Repositories\Interfaces\API\ProfileApiRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProfileApiController
{
    protected $profileApiRepo;
    public function __construct(ProfileApiRepositoryInterface $profileApiRepo)
    {
        $this->profileApiRepo = $profileApiRepo;
    }
    /**
     * Get all Profile as Collection from Resource
     * @return JsonResponse|ProfileCollection
     */
    public function getAllProfiles()
    {
        try {
            $user = Auth::user();

            if ($user->role !== User::ADMIN) {
                return response()->json([
                    'error' => 'Only Admin is Allowed to See All Profiles.'
                ], JsonResponse::HTTP_FORBIDDEN);
            }

            $allProfiles = $this->profileApiRepo->getAll();

            return new ProfileApiCollection($allProfiles);

        } catch (Exception $e) {

            return response()->json([
                'error' => true,
                'message' => "Failed get All Profiles",
                'detail' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show specified Profile Detail using Resource
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $user = Auth::user();

            if ($user->role !== User::ADMIN) {
                return response()->json([
                    'error' => 'Only Admin is Allowed to See a Profile.'
                ], JsonResponse::HTTP_FORBIDDEN);
            }

            $profile = $this->profileApiRepo->findById($id);

            return response()->json([
                'profile' => new ProfileApiResource($profile),
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {

            return response()->json([
                'error' => true,
                'message' => "Failed to Show Profile",
                'detail' => $e->getMessage(),
            ], JsonResponse::HTTP_NOT_FOUND);
        }
    }

    /**
     * Create a New Profile using Request Inputs
     * @return JsonResponse
     */
    public function store(ProfileApiRequest $request)
    {
        try {
            $user = Auth::user();

            if ($user->role !== User::ADMIN) {
                return response()->json([
                    'error' => 'Only Admin is Allowed to Create new Profile.'
                ], JsonResponse::HTTP_FORBIDDEN);
            }

            $data = $request->all();

            if ($request->hasFile('picture')) {
                $data['picture'] = $request->file('picture');
            }

            $profile = $this->profileApiRepo->store($data);

            return response()->json([
                'profile' => new ProfileApiResource($profile)
            ], JsonResponse::HTTP_CREATED);
        } catch (Exception $e) {

            return response()->json([
                'error' => true,
                'message' => "Failed to Create profile",
                'detail' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update as Existing Profile using New Request Inputs
     * @return JsonResponse
     */
    public function update($id, ProfileApiRequest $request)
    {
        try {

            $user = Auth::user();

            if ($user->role !== User::ADMIN) {
                return response()->json([
                    'error' => 'Only Admin is Allowed to Update a Profile.'
                ], JsonResponse::HTTP_FORBIDDEN);
            }

            $data = $request->all();

            if ($request->hasFile('picture')) {
                $data['picture'] = $request->file('picture');
            }

            $profile = $this->profileApiRepo->update($id, $data);

            return response()->json([
                'profile' => new ProfileApiResource($profile)
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {

            return response()->json([
                'error' => true,
                'message' => "Failed to Update profile",
                'detail' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete a Specific Profile by ID
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $user = Auth::user();

            if ($user->role !== User::ADMIN) {
                return response()->json([
                    'error' => 'Only Admin is Allowed to Delete a Profile.'
                ], JsonResponse::HTTP_FORBIDDEN);
            }

            $this->profileApiRepo->delete($id);

            return response()->json(['message' => 'Profile deleted successfully!']);

        } catch (Exception $e) {

            return response()->json([
                'message' => "Failed to delete profile"
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
