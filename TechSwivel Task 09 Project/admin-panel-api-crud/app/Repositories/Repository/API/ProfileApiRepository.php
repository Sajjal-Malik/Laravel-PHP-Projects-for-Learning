<?php

namespace App\Repositories\Repository\API;

use App\Models\Profile;
use App\Repositories\Interfaces\API\ProfileApiRepositoryInterface;
use App\Traits\FileUploadTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Google\Cloud\Firestore\FirestoreClient;

class ProfileApiRepository implements ProfileApiRepositoryInterface
{
    use FileUploadTrait;

    protected $firestore;
    public function __construct()
    {
        $this->firestore = new FirestoreClient([
            'projectId' => env('FIREBASE_PROJECT_ID'),
        ]);
    }

    /**
     * Get all profiles from DB
     * @return array|Collection
     */
    public function getAll()
    {
        try {
            $allProfiles = Profile::latest(Profile::CREATED_AT)->get();

            return $allProfiles;
        } catch (Exception $e) {

            Log::error('Error fetching profiles: ' . $e->getMessage());

            throw new Exception('Could not fetch profiles: ' . $e->getMessage());
        }
    }
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
     * Create a new profile and save it to DB and Firestore
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

            $this->firestore->collection('profiles')->document((string)$profile->id)->set([
                ...$data, 'id' => $profile->id]);

            DB::commit();

            return $profile;
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error creating profile: ' . $e->getMessage());

            throw new Exception('Could not create profile: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing profile in DB and cloud firestore
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

            $this->firestore->collection('profiles')->document((string) $profile->id)->set([
                ...$data, 'id' => $profile->id]);


            DB::commit();

            return $profile;
        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Error updating profile with ID ' . $id . ': ' . $e->getMessage());

            throw new Exception('Could not update profile with ID ' . $id . ': ' . $e->getMessage());
        }
    }
    /**
     * Delete a profile by ID from DB and cloud firestore
     * @return bool
     */
    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $profile = Profile::findOrFail($id);

            $this->deleteImage($profile->picture);

            $this->firestore->collection('profiles')->document((string) $id)->delete();

            $profile->delete();

            DB::commit();

            return true;
        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Error deleting profile with ID ' . $id . ': ' . $e->getMessage());

            throw new Exception('Could not delete profile with ID ' . $id . ': ' . $e->getMessage());
        }
    }
}
