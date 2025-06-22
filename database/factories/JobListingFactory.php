<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobListing>
 */
class JobListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph(5),
            'location' => $this->faker->city,
            'job_type' => $this->faker->randomElement(['Full-time', 'Part-time', 'Contract']),
            'salary_range' => 'Rp. ' . $this->faker->numberBetween(5, 20) . '.000.000',
            'status' => 'open',
            'education_level' => $this->faker->randomElement(['SMA/SMK', 'D3', 'S1', 'S2']),
            'experience_years' => $this->faker->numberBetween(0, 10),
        ];
    }
}
