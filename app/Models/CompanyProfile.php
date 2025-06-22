<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'company_name',
        'logo',
        'description',
        'website',
        'address',
    ];

    // --- RELASI ---

    /**
     * Relasi ke User (satu-ke-satu, invers).
     * CompanyProfile ini "dimiliki oleh" satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Lowongan Kerja (satu-ke-banyak).
     * Sebuah CompanyProfile dapat memposting banyak JobListing.
     */
    public function jobListings()
    {
        return $this->hasMany(JobListing::class);
    }
}