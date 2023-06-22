<?php

namespace App\Services;

use App\Repositories\BrandRepository;
use App\Http\Resources\BrandResource;
use App\Http\Requests\CreateBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

class BrandService implements \App\Interfaces\BrandServiceInterface
{
    private $repository;

    public function __construct(BrandRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(CreateBrandRequest $request) :BrandResource
    {
        $data = $this->repository->create($request->toArray());

        $resource = new BrandResource($data);

        return $resource;
    }

    public function update(UpdateBrandRequest $request, $id): BrandResource
    {
        $data = $this->repository->update($id, $request->toArray());

        $resource = new BrandResource($data);

        return $resource;
    }

    public function delete($id): void
    {
        $this->repository->delete($id);
    }

    public function read($id): BrandResource
    {
        $data = $this->repository->findById($id);

        $resource = new BrandResource($data);

        return $resource;
    }

    public function all() :\Illuminate\Pagination\LengthAwarePaginator
    {
        $collections = $this->repository->all();
        $collectionsMap = $collections->getCollection()->map(function ($collection) {
            return new BrandResource($collection);
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