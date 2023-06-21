<?php

namespace App\Repositories;

use App\Models\Photo;

class PhotoRepository implements \App\Interfaces\PhotoRepositoryInterface
{
    public function all() :\Illuminate\Database\Eloquent\Collection|static
    {
        return Photo::all();
    }

    public function findById($id) :Photo
    {
        $data = Photo::find($id);

        if (!$data) {
            throw new \Exception("Photo not found", 1);
        }

        return $data;
    }

    public function create(array $data) :Photo
    {
        return Photo::create($data);
    }

    public function update($id, array $data) :Photo
    {
        $model = $this->findById($id);
        $model->update($data);

        return $model;
    }

    public function delete($id) :void
    {
        $this->findById($id);

        Photo::destroy($id);
    }
}