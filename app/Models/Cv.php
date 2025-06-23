<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    protected $fillable = ['seeker_profile_id', 'file_name', 'file_path'];

    public function seekerProfile()
    {
        return $this->belongsTo(SeekerProfile::class);
    }
}
