<?php

namespace App\Services;

use App\Repositories\PhotoRepository;
use App\Http\Resources\PhotoResource;
use App\Http\Requests\CreatePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;

class PhotoService implements \App\Interfaces\PhotoServiceInterface
{
    private $repository;

    public function __construct()
    {
        $this->repository = new PhotoRepository();
    }

    public function create(CreatePhotoRequest $request) :PhotoResource
    {
        $data = $this->repository->create($request->toArray());

        $resource = new PhotoResource($data);

        return $resource;
    }

    public function update(UpdatePhotoRequest $request, $id): PhotoResource
    {
        $data = $this->repository->update($id, $request->toArray());

        $resource = new PhotoResource($data);

        return $resource;
    }

    public function delete($id): void
    {
        $this->repository->delete($id);
    }

    public function read($id): PhotoResource
    {
        $data = $this->repository->findById($id);

        $resource = new PhotoResource($data);

        return $resource;
    }

    public function all() :\Illuminate\Database\Eloquent\Collection|static
    {
        $collections = $this->repository->all();
        $collections->transform(function($collection) {
            return new PhotoResource($collection);
        });

        return $collections;
    }
}