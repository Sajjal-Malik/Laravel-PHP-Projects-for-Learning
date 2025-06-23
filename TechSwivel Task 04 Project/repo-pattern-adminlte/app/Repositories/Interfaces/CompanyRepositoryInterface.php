<?php 

namespace App\Repositories\Interfaces;

interface CompanyRepositoryInterface
{
    public function all();

    public function store(array $data);

    public function find($id);
    
    public function update($id, array $data);

    public function delete($id);
}