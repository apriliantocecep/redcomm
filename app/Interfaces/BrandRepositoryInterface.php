<?php

namespace App\Interfaces;

use App\Models\Brand;

interface BrandRepositoryInterface
{
    public function all() :\Illuminate\Pagination\LengthAwarePaginator;
    public function findById($id) :Brand;
    public function create(array $data) :Brand;
    public function update($id, array $data) :Brand;
    public function delete($id) :void;
}