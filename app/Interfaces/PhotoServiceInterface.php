<?php

namespace App\Interfaces;

use App\Http\Requests\CreatePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;
use App\Http\Resources\PhotoResource;

interface PhotoServiceInterface
{
    public function create(CreatePhotoRequest $request) :PhotoResource;
    public function read($id) :PhotoResource;
    public function update(UpdatePhotoRequest $request, $id) :PhotoResource;
    public function delete($id) :void;
    public function all() :\Illuminate\Database\Eloquent\Collection|static;
}