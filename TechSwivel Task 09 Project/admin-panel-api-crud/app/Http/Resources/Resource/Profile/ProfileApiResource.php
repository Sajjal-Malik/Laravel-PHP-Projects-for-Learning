<?php

namespace App\Http\Resources\Resource\Profile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fullName' => "{$this->firstName} {$this->lastName}",
            'email' => $this->email,
            'phoneNumber' => $this->phoneNumber,
            'gender' => $this->gender,
            'age' => $this->age,
            'ageStatus' => $this->ageStatus?->value ?? null,
            'picture' => $this->picture
                ? asset('storage/' . $this->picture)
                : null,
        ];
    }
}
