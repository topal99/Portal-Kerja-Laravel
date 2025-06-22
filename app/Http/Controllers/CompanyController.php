<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function show(CompanyProfile $companyProfile)
    {
    // Ambil lowongan yang statusnya 'open' dari perusahaan ini saja
    $activeJobs = $companyProfile->jobListings()
    ->where('status', 'open')
    ->latest()
    ->paginate(5); // Tampilkan 5 lowongan per halaman di profil perusahaan

        // Kita tetap butuh $appliedJobIds agar partial job-card berfungsi dengan benar
        $appliedJobIds = collect();
        if (Auth::check() && Auth::user()->role === 'seeker') {
            $appliedJobIds = Auth::user()->seekerProfile->jobApplications()->pluck('job_listing_id');
        }

        return view('companies.show', [
            'company' => $companyProfile,
            'activeJobs' => $activeJobs,
            'appliedJobIds' => $appliedJobIds,
        ]);
    }
}