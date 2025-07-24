<?php

namespace App\Http\Resources\Collection\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Resource\Profile\ProfileApiResource;


class ProfileApiCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'profiles' => ProfileApiResource::collection($this->collection),
            'meta' => ['count' => $this->collection->count()],
        ];
    }
}
