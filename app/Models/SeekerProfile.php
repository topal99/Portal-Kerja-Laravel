<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeekerProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'full_name',
        'resume_path',
        'photo',
        'phone_number',
        'skills',
    ];

    // --- RELASI ---

    /**
     * Relasi ke User (satu-ke-satu, invers).
     * SeekerProfile ini "dimiliki oleh" satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Lamaran Kerja (satu-ke-banyak).
     * Seorang pencari kerja dapat mengirim banyak JobApplication.
     */
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
}