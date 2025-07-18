<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\WriteFirestoreRequest;
use App\Repositories\Interfaces\FirestoreRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class FirestoreController extends Controller
{
    protected $firestoreRepo;
    public function __construct(FirestoreRepositoryInterface $firestoreRepo)
    {
        $this->firestoreRepo = $firestoreRepo;
    }

    /**
     * Rider writes Specified Order Data to Firestore
     * @return mixed|JsonResponse
     */
    public function write(WriteFirestoreRequest $writeFirestoreRequest)
    {
        try{
            $success = $this->firestoreRepo->writeOrderToFirestore($writeFirestoreRequest->all());
            if($success){
                return response()->json([
                    'message' => 'Order Synced to Firestore',
                ], 200);
            }
            return response()->json([
                'error' => 'Failed to Sync order',
            ], 500);
        }
        catch(Exception $e){
            return response()->json([
                'error' => 'Failed to Sync order ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Customer reads Data of Specific Order
     * @return mixed|JsonResponse
     */
    public function read($orderId)
    {
        try{
            $data = $this->firestoreRepo->readOrderFromFirestore($orderId);
            if($data){
                return response()->json([
                    'order' => $data
                ]);
            }
            return response()->json(['message' => 'Order not found.'], 404);
        }
        catch(Exception $e){

            return response()->json([
                'error' => 'Order not found ' . $e->getMessage(),
            ]);
        }

    }
}
