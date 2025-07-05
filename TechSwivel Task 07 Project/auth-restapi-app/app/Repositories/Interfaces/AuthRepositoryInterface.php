<?php

namespace App\Repositories\Interfaces;

interface AuthRepositoryInterface
{
    /**
     * User Registration function declaration.
     */
    public function register(array $data);
    /**
     * User Login function declaration.
     */
    public function login(array $credentials);
    /**
     * Get User Profile function declaration.
     */
    public function getProfile();
    /**
     * Send Reset Token function declaration.
     */
    public function sendResetToken(array $data);
    /**
     * Verify Reset Token function declaration.
     */
    public function verifyResetToken(array $data);
    /**
     * Reset Password using Token function declaration.
     */
    public function resetPassword(array $data);
}
