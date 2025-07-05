<?php

namespace App\Repositories\Repository;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Traits\FileUploadTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostRepository implements PostRepositoryInterface
{
    use FileUploadTrait;

    /**
     * List all Posts from the DB
     * @return array|Collection
     */
    public function index()
    {
        return Post::with('author')->latest()->get();
    }

    /**
     * Show current Post specified by id
     * @param mixed $id
     * @return array|Builder|Collection|Model
     */
    public function show($id)
    {
        return Post::with('comments')->findOrFail($id);
    }

    /**
     * Store or Add Current Post in the DB
     * @param array $data
     * @return Post|Model
     */
    public function store(array $data)
    {
        try {
            DB::beginTransaction();

            $data['createdBy'] = Auth::id();

            if (isset($data['image'])) {
                $data['image'] = $this->uploadImage($data['image']);
            }

            DB::commit();

            return Post::create($data);
        } catch (Exception $e) {

            DB::rollBack();

            throw new Exception("Failed to Create Post" . $e->getMessage());
        }
    }

    /**
     * Update Specified Post in the DB
     * @param mixed $id
     * @param array $data
     * @return array|Post|Collection|Model
     */
    public function update($id, array $data)
    {
        try {
            DB::beginTransaction();

            $post = Post::findOrFail($id);

            if (isset($data['image'])) {
                $data['image'] = $this->uploadImage($data['image']);
            }

            $post->update($data);

            DB::commit();

            return $post;
        } catch (Exception $e) {

            DB::rollBack();

            throw new Exception("Failed to Update Post" . $e->getMessage());
        }
    }

    /**
     * Delete Specified Comment from the DB
     * @param mixed $id
     * @return bool|mixed|null
     */
    public function destroy($id)
    {
        try {
            return Post::findOrFail($id)->delete();
        } catch (Exception $e) {

            throw new Exception("Failed to Delete Post" . $e->getMessage());
        }
    }
}
