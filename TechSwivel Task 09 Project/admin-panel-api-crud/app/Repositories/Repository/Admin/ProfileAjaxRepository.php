<?php

namespace App\Repositories\Repository\Admin;

use App\Models\Profile;
use App\Repositories\Interfaces\Admin\ProfileAjaxRepositoryInterface;
use App\Traits\FileUploadTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileAjaxRepository implements ProfileAjaxRepositoryInterface
{
    use FileUploadTrait;
    /**
     * Find a profile by ID from DB
     * @return array|Builder|Collection|Model
     */
    public function findById($id)
    {
        try {
            return Profile::findOrFail($id);
        } catch (Exception $e) {

            Log::error('Error finding profile with ID ' . $id . ': ' . $e->getMessage());

            throw new Exception('Could not find profile with ID ' . $id . ': ' . $e->getMessage());
        }
    }
    /**
     * Create a new profile and save it to DB
     * @return Builder|Model
     */
    public function store(array $data)
    {
        try {
            DB::beginTransaction();

            if (isset($data['picture'])) {
                $data['picture'] = $this->uploadImage($data['picture']);
            }

            $profile = Profile::create($data);

            DB::commit();

            return $profile;
        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Error creating profile: ' . $e->getMessage());

            throw new Exception('Could not create profile: ' . $e->getMessage());
        }
    }
    /**
     * Update an existing profile in DB
     * @return array|Builder|Collection|Model
     */
    public function update($id, array $data)
    {
        try {
            DB::beginTransaction();

            $profile = Profile::findOrFail($id);

            if (isset($data['picture'])) {
                $this->deleteImage($profile->picture);
                $data['picture'] = $this->uploadImage($data['picture']);
            }

            $profile->update($data);

            DB::commit();

            return $profile;
        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Error updating profile with ID ' . $id . ': ' . $e->getMessage());

            throw new Exception('Could not update profile with ID ' . $id . ': ' . $e->getMessage());
        }
    }
    /**
     * Delete a profile by ID from DB
     * @return bool
     */
    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $profile = Profile::findOrFail($id);

            $this->deleteImage($profile->picture);

            $profile->delete();

            DB::commit();

            return true;
        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Error deleting profile with ID ' . $id . ': ' . $e->getMessage());

            throw new Exception('Could not delete profile with ID ' . $id . ': ' . $e->getMessage());
        }
    }

    /**
     * Count the existing Profiles
     * @return mixed
     */
    public function count()
    {
        try {
            $totalProfiles = Profile::count();

            return $totalProfiles;
        } catch (Exception $e) {

            Log::error("Failed to return Profile count: " . $e->getMessage());

            throw new Exception("Failed to return Profile count: " . $e->getMessage());
        }
    }
}
