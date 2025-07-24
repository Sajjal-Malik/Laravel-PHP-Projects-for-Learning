<?php

namespace App\Repositories\Interfaces\API;

interface AdminAuthRepositoryInterface
{
    /**
     * For Admin Login
     */
    public function login(array $credentials);
    /**
     * For Admin Logout
     */
    public function logout();
}