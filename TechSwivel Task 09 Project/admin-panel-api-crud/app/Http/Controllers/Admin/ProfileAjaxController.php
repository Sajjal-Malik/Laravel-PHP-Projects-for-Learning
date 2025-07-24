<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProfileDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileAjaxRequest;
use App\Http\Resources\Resource\Profile\ProfileAjaxResource;
use App\Repositories\Interfaces\Admin\ProfileAjaxRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;

class ProfileAjaxController extends Controller
{
    protected $profileAjaxRepo;

    public function __construct(ProfileAjaxRepositoryInterface $profileAjaxRepo)
    {
        $this->profileAjaxRepo = $profileAjaxRepo;
    }

    /**
     * Profile DataTable view on Admin Panel
     * @return ProfileDataTable
     */
    public function index(ProfileDataTable $profileDataTable)
    {
        try {
            return $profileDataTable->render('admin.profiles.index');

        } catch (Exception $e) {

            return back()->withErrors(['error' => 'Failed to load Profiles DataTable.']);
        }
    }

    /**
     * Get the Specific Profile
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $profile = $this->profileAjaxRepo->findById($id);

            return response()->json([
                'data' => new ProfileAjaxResource($profile),
            ]);

        } catch (Exception $e) {

            return response()->json([
                'message' => "Failed to open profile for editing"
            ]);
        }
    }

    /**
     * Create a Profile using Modal from Admin panel
     * @return JsonResponse
     */
    public function store(ProfileAjaxRequest $request): JsonResponse
    {
        try {
            $data = $request->all();

            if ($request->hasFile('picture')) {
                $data['picture'] = $request->file('picture');
            }

            $profile = $this->profileAjaxRepo->store($data);

            return response()->json([
                'message' => "Profile created successfully!",
                'data' => new ProfileAjaxResource($profile),
            ]);

        } catch (Exception $e) {

            return response()->json([
                'message' => "Failed to create profile"
            ]);
        }
    }

    /**
     * Load the Modal for Editing the Profile
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        try {
            $profile = $this->profileAjaxRepo->findById($id);

            return response()->json([
                'data' => new ProfileAjaxResource($profile),
            ]);

        } catch (Exception $e) {

            return response()->json([
                'message' => "Failed to Open profile for editing"
            ]);
        }
    }

    /**
     * Update the Requested Profile using Modal
     * @return JsonResponse
     */
    public function update($id, ProfileAjaxRequest $request): JsonResponse
    {
        try {
            $data = $request->all();

            if ($request->hasFile('picture')) {
                $data['picture'] = $request->file('picture');
            }

            $profile = $this->profileAjaxRepo->update($id, $data);

            return response()->json([
                'message' => 'Profile updated successfully!',
                'data' => new ProfileAjaxResource($profile),
            ]);

        } catch (Exception $e) {

            return response()->json([
                'message' => "Failed to update profile"
            ]);
        }
    }

    /**
     * Delete the Specified Profile from DataTable
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->profileAjaxRepo->delete($id);

            return response()->json(['message' => 'Profile deleted successfully!']);

        } catch (Exception $e) {

            return response()->json([
                'message' => "Failed to delete profile"
            ]);
        }
    }

    /**
     * Count Profiles and Show Count on Viwe
     * @return Factory|View|RedirectResponse
     */
    public function count()
    {
        try{
            $totalProfiles = $this->profileAjaxRepo->count();
    
            return view('admin.dashboard', ['totalProfiles' => $totalProfiles]);
        }
        catch(Exception $e){

            return redirect()->back()->with('error', "Failed to return Total profiles count" . $e->getMessage());
        }
    }
}
