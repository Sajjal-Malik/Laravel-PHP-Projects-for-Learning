<?php

namespace Database\Factories;

use App\Models\Company;
use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    use FileUploadTrait;

    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name'    => $this->faker->company,
            'email'   => $this->faker->optional()->companyEmail,
            'website' => $this->faker->optional()->url,
            'logo'    => $this->uploadFileFromFactory('logo.png', 'company-logos'),
        ];
    }
}
