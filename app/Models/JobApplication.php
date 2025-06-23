<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'job_listing_id',
        'seeker_profile_id',
        'cover_letter',
        'status',
        'cv_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    // --- RELASI ---

    /**
     * Relasi ke JobListing (banyak-ke-satu).
     * Lamaran ini ditujukan untuk satu JobListing.
     */
    public function jobListing()
    {
        return $this->belongsTo(JobListing::class);
    }

    /**
     * Relasi ke SeekerProfile (banyak-ke-satu).
     * Lamaran ini dikirim oleh satu SeekerProfile.
     */
    public function seekerProfile()
    {
        return $this->belongsTo(SeekerProfile::class);
    }

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}
