<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_profile_id',
        'title',
        'description',
        'location',
        'job_type',
        'salary_range',
        'status',
        'education_level',    
        'experience_years',
    ];

    /**
     * The attributes that should be cast.
     * Di Laravel modern, casting ke Enum secara otomatis membuat
     * interaksi dengan kolom ini lebih aman dan mudah.
     *
     * @var array
     */
    protected $casts = [
        // Jika Anda menggunakan Enum Class di PHP, Anda bisa menentukannya di sini.
        // Jika tidak, Laravel akan menanganinya sebagai string biasa.
    ];


    // --- RELASI ---

    /**
     * Relasi ke CompanyProfile (banyak-ke-satu).
     * Sebuah JobListing "dimiliki oleh" satu CompanyProfile.
     */
    public function companyProfile()
    {
        return $this->belongsTo(CompanyProfile::class);
    }

    /**
     * Relasi ke Lamaran Kerja (satu-ke-banyak).
     * Sebuah JobListing bisa memiliki banyak JobApplication.
     */
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
}