<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Exception;

class CommentController extends Controller
{
    protected $commentRepo;
    public function __construct(CommentRepositoryInterface $commentRepo)
    {
        $this->commentRepo = $commentRepo;
    }

    /**
     * Get the List of All Comments
     * @return JsonResponse|mixed
     */
    public function index(): JsonResponse
    {
        try{
            $comments = $this->commentRepo->index();
            return response()->json(CommentResource::collection($comments), 200);
        }
        catch (Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => 'Failed to Load All Comments',
                'detail'  => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Validate data using Form Request and Add Current Comment
     * @return JsonResponse|mixed
     */
    public function store(CommentRequest $request): JsonResponse
    {
        try {
            $comment  = $this->commentRepo->store($request->all());

            return response()->json(new CommentResource($comment), 201);

        } catch (Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => 'Comment creation failed',
                'detail'  => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show Specified Comment for Editing
     * @param int $id
     * @return JsonResponse|mixed
     */
    public function edit(int $id): JsonResponse
    {
        try {
            $comment = $this->commentRepo->show($id);
            return response()->json(new CommentResource($comment), 200);

        } catch (Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => 'Comment not found',
                'detail'  => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Validate and Update the Specified Comment
     * @param int $id
     * @return JsonResponse|mixed
     */
    public function update(CommentRequest $request, int $id): JsonResponse
    {
        try {
            $comment = $this->commentRepo->update($id, $request->all());
            return response()->json(new CommentResource($comment), 200);

        } catch (Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => 'Comment update failed',
                'detail'  => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete the Specified Comment
     * @param int $id
     * @return JsonResponse|mixed
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->commentRepo->destroy($id);

            return response()->json(['message' => 'Comment deleted'], 200);

        } catch (Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => 'Comment delete failed',
                'detail'  => $e->getMessage(),
            ], 500);
        }
    }
}
