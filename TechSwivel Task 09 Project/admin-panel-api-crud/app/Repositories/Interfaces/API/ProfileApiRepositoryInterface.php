<?php

namespace App\Repositories\Interfaces\API;

interface ProfileApiRepositoryInterface
{
    /**
     * Get all profiles
     */
    public function getAll();
    /**
     * Find a profile by ID
     */
    public function findById($id);
    /**
     * Create a new profile
     */
    public function store(array $data);
    /**
     * Update an existing profile
     */
    public function update($id, array $data);
    /**
     * Delete a profile by ID
     */
    public function delete($id);
}
