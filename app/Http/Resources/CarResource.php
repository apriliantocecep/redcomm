<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $photos = $this->photos;
        $photos->transform(function($photo) {
            return new PhotoResource($photo);
        });

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'year' => $this->year,
            'color' => $this->color,
            'brand' => $this->brand ? new BrandResource($this->brand) : null,
            'created_by' => $this->user ? new UserResource($this->user) : null,
            'photos' => $photos,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
