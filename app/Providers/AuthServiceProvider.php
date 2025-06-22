<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

// TAMBAHKAN DUA BARIS INI
use App\Models\JobListing;
use App\Policies\JobListingPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // TAMBAHKAN SATU BARIS INI
        JobListing::class => JobListingPolicy::class,
        JobApplication::class => JobApplicationPolicy::class, // <-- Tambahkan ini

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}