<?php

namespace App\Repositories\Interfaces;

interface UserManagementRepositoryInterface
{
    /**
     * Load all Riders
     */
    public function getAllRiders();
    /**
     * Create a Rider
     */
    public function storeRider(array $data);

    /**
     * Load all Customers
     */
    public function getAllCustomers();
    /**
     * Create a Customer
     */
    public function storeCustomer(array $data);
    /**
     * User Registration function declaration.
     */
    public function register(array $data);
    /**
     * User Login function declaration.
     */
    public function login(array $credentials);
    /**
     * Update User Profile function
     */
    public function updateProfile(array $data);
}
