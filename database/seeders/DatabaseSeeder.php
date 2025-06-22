<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobListing;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // 1. Buat 1 Admin Utama
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);

        // 2. Buat 5 Perusahaan, masing-masing dengan 10 lowongan
        User::factory(5)->create(['role' => 'company'])
            ->each(function($companyUser) {
                JobListing::factory(10)->create([
                    'company_profile_id' => $companyUser->companyProfile->id
                ]);
            });
    }
}
