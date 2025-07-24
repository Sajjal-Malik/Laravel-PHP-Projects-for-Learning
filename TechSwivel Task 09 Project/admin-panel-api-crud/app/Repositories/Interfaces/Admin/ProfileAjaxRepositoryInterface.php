<?php

namespace App\Repositories\Interfaces\Admin;

interface ProfileAjaxRepositoryInterface
{
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
    /**
     * Count the existing profiles
     */
    public function count();
}