<?php

namespace App\Repositories\Interfaces;

interface FirestoreRepositoryInterface
{
    /**
     * Write data to Firestore by Rider
     */
    public function writeOrderToFirestore(array $data);
    /**
     * Read data from Firestore by Customer
     */
    public function readOrderFromFirestore($orderId);
}