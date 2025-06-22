<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Penting untuk bisa diisi saat registrasi atau diubah oleh admin
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELASI ---

    /**
     * Relasi ke profil perusahaan (satu-ke-satu).
     * Sebuah User hanya memiliki satu CompanyProfile.
     */
    public function companyProfile()
    {
        return $this->hasOne(CompanyProfile::class);
    }

    /**
     * Relasi ke profil pencari kerja (satu-ke-satu).
     * Sebuah User hanya memiliki satu SeekerProfile.
     */
    public function seekerProfile()
    {
        return $this->hasOne(SeekerProfile::class);
    }
}