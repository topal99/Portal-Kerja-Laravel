<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyProfile>
 */
class CompanyProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Kita tidak perlu mendefinisikan 'user_id' dan 'company_name' di sini,
            // karena kita akan mengisinya secara manual dari DatabaseSeeder/UserFactory.
            
            // Kolom-kolom opsional kita isi dengan data palsu dari Faker.
            'description' => $this->faker->paragraph(4),
            'website' => 'https://www.' . $this->faker->domainName,
            'address' => $this->faker->address,
            'logo' => 'logos/logos.png', // Kita biarkan null secara default, bisa diisi nanti.
        ];
    }
}