<?php

namespace App\Interfaces;

use App\Http\Requests\CreateBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;

interface BrandServiceInterface
{
    public function create(CreateBrandRequest $request) :BrandResource;
    public function read($id) :BrandResource;
    public function update(UpdateBrandRequest $request, $id) :BrandResource;
    public function delete($id) :void;
    public function all() :\Illuminate\Pagination\LengthAwarePaginator;
}