<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama dengan daftar lowongan kerja.
     */
    public function index(Request $request)
    {
        $appliedJobIds = collect(); 

        if (auth()->check() && auth()->user()->role === 'seeker') {
            $appliedJobIds = auth()->user()->seekerProfile
                                ->jobApplications()
                                ->pluck('job_listing_id');
        }

        // Mulai query dasar
        $query = JobListing::where('status', 'open')->with('companyProfile');

        // Terapkan filter jika ada input
        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        // Eksekusi query dengan urutan terbaru dan pagination
        $jobs = $query->latest()->paginate(9)->withQueryString();

        return view('welcome', [
            'jobs' => $jobs,
            'appliedJobIds' => $appliedJobIds
        ]);
    }

    /**
     * Menampilkan halaman detail untuk satu lowongan kerja.
     */
    public function show(JobListing $jobListing)
    {
        // --- Logika untuk Cek Lamaran (sudah ada) ---
        $hasApplied = false;
        $appliedJobIds = collect(); // Diperlukan untuk partial job-card
        if (Auth::check() && Auth::user()->role === 'seeker') {
            $seekerProfile = Auth::user()->seekerProfile;
            $hasApplied = $seekerProfile->jobApplications()
                                        ->where('job_listing_id', $jobListing->id)
                                        ->exists();
            // Ambil semua ID lamaran untuk digunakan di partial 'job-card'
            $appliedJobIds = $seekerProfile->jobApplications()->pluck('job_listing_id');
        }

        // --- LOGIKA BARU UNTUK LOWONGAN TERKAIT ---
        $relatedJobs = JobListing::where('status', 'open')
            // 1. Jangan tampilkan lowongan yang sedang dilihat saat ini
            ->where('id', '!=', $jobListing->id)
            // 2. Cari yang cocok berdasarkan salah satu dari kriteria ini
            ->where(function ($query) use ($jobListing) {
                $query->where('company_profile_id', $jobListing->company_profile_id) // Dari perusahaan yang sama
                    ->orWhere('location', $jobListing->location) // Di lokasi yang sama
                    ->orWhere('job_type', $jobListing->job_type); // Dengan tipe pekerjaan yang sama
            })
            ->with('companyProfile') // Eager loading untuk performa
            ->latest() // Tampilkan yang terbaru
            ->take(3) // Ambil maksimal 3 lowongan terkait
            ->get();
        
        // --- Kirim semua data yang dibutuhkan ke view ---
        return view('jobs.show', [
            'job' => $jobListing,
            'hasApplied' => $hasApplied,
            'relatedJobs' => $relatedJobs,
            'appliedJobIds' => $appliedJobIds, // Kirim ini juga untuk partial
        ]);
    }

}