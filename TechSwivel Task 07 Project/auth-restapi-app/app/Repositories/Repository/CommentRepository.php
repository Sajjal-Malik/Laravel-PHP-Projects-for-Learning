<?php

namespace App\Repositories\Repository;

use App\Models\Comment;
use App\Models\Post;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * List all Comments from the DB
     * @return array|Collection
     */
    public function index()
    {
        return Comment::with('author')->get();
    }

    /**
     * Show current Comment specified by id
     * @param mixed $id
     * @return array|Builder|Collection|Model
     */
    public function show($id)
    {
        return Comment::with(['author', 'post:id,title'])->findOrFail($id);
    }

    /**
     * Store or Add Current Comment in the DB
     * @param array $data
     * @return Comment|Model
     */
    public function store(array $data)
    {
        try {
            DB::beginTransaction();

            $data['createdBy'] = Auth::id();

            DB::commit();

            return Comment::create($data);
        } catch (Exception $e) {

            DB::rollBack();

            throw new Exception("Failed to Create Comment" . $e->getMessage());
        }
    }

    /**
     * Update Specified Comment in the DB
     * @param mixed $id 
     * @param array $data
     * @return Comment|Collection|Model
     */
    public function update($id, array $data)
    {
        try {
            DB::beginTransaction();

            $comment = Comment::findOrFail($id);

            $comment->update($data);

            DB::commit();

            return $comment;
        } catch (Exception $e) {

            DB::rollBack();

            throw new Exception("Failed to Update Comment" . $e->getMessage());
        }
    }

    /**
     * Delete Spcified Comment from the DB
     * @param mixed $id
     * @return bool|mixed|null
     */
    public function destroy($id)
    {
        try {
            return Comment::findOrFail($id)->delete();
        } catch (Exception $e) {

            throw new Exception("Failed to Delete Comment" . $e->getMessage());
        }
    }
}
