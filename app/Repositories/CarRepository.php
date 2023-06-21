<?php

namespace App\Repositories;

use App\Models\Car;

class CarRepository implements \App\Interfaces\CarRepositoryInterface
{
    public function all() :\Illuminate\Pagination\LengthAwarePaginator
    {
        $collection = Car::paginate(10)->withQueryString();

        return $collection;
    }

    public function findById($id) :Car
    {
        $data = Car::find($id);

        if (!$data) {
            throw new \Exception("Car not found", 1);
        }

        return $data;
    }

    public function create(array $data) :Car
    {
        return Car::create($data);
    }

    public function update($id, array $data) :Car
    {
        $model = $this->findById($id);
        $model->update($data);

        return $model;
    }

    public function delete($id) :void
    {
        $this->findById($id);

        Car::destroy($id);
    }
}