<?php

namespace App\Repositories\Repository;

use App\Repositories\Interfaces\FirestoreRepositoryInterface;
use Exception;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\Facades\Log;

class FirestoreRepository implements FirestoreRepositoryInterface
{
    protected $firestore;
    public function __construct()
    {
        $this->firestore = new FirestoreClient([
            'projectId' => env('FIREBASE_PROJECT_ID'),
        ]);
    }
     /**
     * Write data to Firestore by Rider
     * @return bool
     */
    public function writeOrderToFirestore(array $data)
    {
        try{
            $this->firestore->collection('orders')->document($data['orderId'])->set($data);
            return true;
        }
        catch(Exception $e){

            Log::error('Firestore write error: ' . $e->getMessage());

            throw new Exception('Firestore write error: ' . $e->getMessage());
        }
    }
    /**
     * Read data from Firestore by Customer
     * @return mixed
     */
    public function readOrderFromFirestore($orderId)
    {
        try{
            $document = $this->firestore->collection('orders')->document($orderId)->snapshot();
            if($document->exists()){
                return $document->data();
            }
            return null;
        }
        catch(Exception $e){

            Log::error('Firestore read error: ' . $e->getMessage());

            throw new Exception('Firestore read error: ' . $e->getMessage());
        }
    }
}