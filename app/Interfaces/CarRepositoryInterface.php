<?php

namespace App\Interfaces;

use App\Models\Car;

interface CarRepositoryInterface
{
    public function all() :\Illuminate\Pagination\LengthAwarePaginator;
    public function findById($id) :Car;
    public function create(array $data) :Car;
    public function update($id, array $data) :Car;
    public function delete($id) :void;
}