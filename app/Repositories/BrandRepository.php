<?php

namespace App\Repositories;

use App\Models\Brand;

class BrandRepository implements \App\Interfaces\BrandRepositoryInterface
{
    public function all() :\Illuminate\Pagination\LengthAwarePaginator
    {
        $collection = Brand::paginate(10)->withQueryString();

        return $collection;
    }

    public function findById($id) :Brand
    {
        $data = Brand::find($id);

        if (!$data) {
            throw new \Exception("Brand not found", 1);
        }

        return $data;
    }

    public function create(array $data) :Brand
    {
        return Brand::create($data);
    }

    public function update($id, array $data) :Brand
    {
        $model = $this->findById($id);
        $model->update($data);

        return $model;
    }

    public function delete($id) :void
    {
        $this->findById($id);

        Brand::destroy($id);
    }
}