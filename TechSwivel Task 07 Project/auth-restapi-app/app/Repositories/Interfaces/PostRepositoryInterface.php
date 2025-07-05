<?php

namespace App\Repositories\Interfaces;

interface PostRepositoryInterface
{
     /**
     * List all Posts function declaration
     */
    public function index();
    /**
     * Show Selected Post function declaration
     */
    public function show($id);
    /**
     * Add New Post function declaration
     */
    public function store(array $data);
    /**
     * Update selected Post function declaration
     */
    public function update($id, array $data);
    /**
     * Delete selected Post function declarations
     */
    public function destroy($id);
}