<?php

namespace App\Interfaces;

use App\Models\Photo;

interface PhotoRepositoryInterface
{
    public function all() :\Illuminate\Database\Eloquent\Collection|static;
    public function findById($id) :Photo;
    public function create(array $data) :Photo;
    public function update($id, array $data) :Photo;
    public function delete($id) :void;
}