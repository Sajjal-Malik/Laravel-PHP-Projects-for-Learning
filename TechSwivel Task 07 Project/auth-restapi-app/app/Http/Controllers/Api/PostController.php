<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Exception;

class PostController extends Controller
{
    protected $postRepo;
    public function __construct(PostRepositoryInterface $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    /**
     * Get the List of All Posts
     * @return mixed|JsonResponse
     */
    public function index()
    {
        try {
            $posts = $this->postRepo->index();

            return response()->json(PostResource::collection($posts), 200);

        } catch (Exception $e) {
            
            return response()->json([
                'error'   => true,
                'message' => 'Post loading failed',
                'detail'  => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Validate data using Form Request and Add Current Post
     * @return mixed|JsonResponse
     */
    public function store(PostRequest $request)
    {
        try {
            $post = $this->postRepo->store($request->all());

            return response()->json(new PostResource($post), 201);

        } catch (Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => 'Post creation failed',
                'detail'  => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show Specified Post for Editing
     * @param mixed $id
     * @return mixed|JsonResponse
     */
    public function edit($id)
    {
        try {
            $post = $this->postRepo->show($id);

            return response()->json(new PostResource($post), 200);

        } catch (Exception $e) {

            return response()->json([
                'error'   => true,
                'message' => 'Post not found',
                'detail'  => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Validate and Update the Specified Post
     * @param mixed $id
     * @return mixed|JsonResponse
     */
    public function update(PostRequest $request, $id)
    {
        try {
            $post = $this->postRepo->update($id, $request->all());

            return response()->json(new PostResource($post), 200);

        } catch (Exception $e) {

            return response()->json([
                'error'   => true,
                'message' => 'Post update failed',
                'detail'  => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete the Specified Post
     * @param mixed $id
     * @return mixed|JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->postRepo->destroy($id);

            return response()->json(['message' => 'Post deleted'], 200);

        } catch (Exception $e) {

            return response()->json([
                'error'   => true,
                'message' => 'Post delete failed',
                'detail'  => $e->getMessage(),
            ], 500);
        }
    }
}
