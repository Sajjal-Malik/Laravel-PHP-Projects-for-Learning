<?php

namespace App\Http\Resources\Resource\Profile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileAjaxResource extends JsonResource
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
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'phoneNumber' => $this->phoneNumber,
            'gender' => $this->gender,
            'age' => $this->age,
            'ageStatus' => $this->ageStatus?->value ?? 'N/A',
            'dob' => Carbon::parse($this->dob)->format('d M Y'),
            'bio' => $this->bio,
            'picture' => $this->picture
                ? asset('storage/' . $this->picture)
                : null,
        ];
    }
}
