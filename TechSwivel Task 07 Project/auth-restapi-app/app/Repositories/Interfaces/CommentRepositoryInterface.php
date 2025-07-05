<?php

namespace App\Repositories\Interfaces;

interface CommentRepositoryInterface
{
    /**
     * List all Comments function declaration
     */
    public function index();
    /**
     * Show Selected Comment function declaration
     */
    public function show($id);
    /**
     * Add New Comment function declaration
     */
    public function store(array $data);
    /**
     * Update selected Comment function declaration
     */
    public function update($id, array $data);
    /**
     * Delete selected Comment function declarations
     */
    public function destroy($id);
}