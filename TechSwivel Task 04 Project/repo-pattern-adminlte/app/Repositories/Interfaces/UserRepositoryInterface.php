<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function all();

    public function find($id);

    public function store(array $data);

    public function toggleBlock($id);
}
