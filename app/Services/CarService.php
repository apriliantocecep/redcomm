<?php

namespace App\Services;

use App\Repositories\CarRepository;
use App\Http\Resources\CarResource;
use App\Http\Requests\CreateCarRequest;
use App\Http\Requests\UpdateCarRequest;

class CarService implements \App\Interfaces\CarServiceInterface
{
    private $repository;

    public function __construct(CarRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(CreateCarRequest $request) :CarResource
    {
        $data = $this->repository->create($request->toArray());

        $resource = new CarResource($data);

        return $resource;
    }

    public function update(UpdateCarRequest $request, $id): CarResource
    {
        $data = $this->repository->update($id, $request->toArray());

        $resource = new CarResource($data);

        return $resource;
    }

    public function delete($id): void
    {
        $this->repository->delete($id);
    }

    public function read($id): CarResource
    {
        $data = $this->repository->findById($id);

        $resource = new CarResource($data);

        return $resource;
    }

    public function all() :\Illuminate\Pagination\LengthAwarePaginator
    {
        $collections = $this->repository->all();
        $collectionsMap = $collections->getCollection()->map(function ($collection) {
            return new CarResource($collection);
        })->toArray();

        $itemsTransformedAndPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $collectionsMap,
            $collections->total(),
            $collections->perPage(),
            $collections->currentPage(), [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        return $itemsTransformedAndPaginated;
    }
}