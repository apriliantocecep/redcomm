<?php

namespace App\Interfaces;

use App\Http\Requests\CreateCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Http\Resources\CarResource;

interface CarServiceInterface
{
    public function create(CreateCarRequest $request) :CarResource;
    public function read($id) :CarResource;
    public function update(UpdateCarRequest $request, $id) :CarResource;
    public function delete($id) :void;
    public function all() :\Illuminate\Pagination\LengthAwarePaginator;
}