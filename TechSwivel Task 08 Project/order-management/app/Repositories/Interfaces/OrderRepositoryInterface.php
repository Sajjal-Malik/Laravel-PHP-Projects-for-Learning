<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface OrderRepositoryInterface
{
    /**
     * Get all orders
     */
    public function getAll();
    /**
     * Getting Rider Data
     */
    public function getRiders();
    /**
     * Getting Customer Data
     */
    public function getCustomers();
    /**
     * Create an Order
     */
    public function create(array $data);
    /**
     * Update Order Status function
     */
    public function updateOrderStatusByRider(array $data);
    /**
     * Function to get All Orders
     */
    public function getAllUserOrders(string $status, User $user);
    /**
     * Get Specific Order Detail
     */
    public function getOrderById($orderId);
    /**
     * Edit Pending Order Description
     */
    public function editPendingOrder($orderId, array $data, User $user);
    /**
     * Feedback upon Order Completeion
     */
    public function submitFeedback(array $data);
    /**
     * Sync Order Data to Firestore
     */
    public function syncFromFirestore(array $data);
}
