<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\JobListing;
use App\Models\JobApplication; 

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil profil perusahaan dari user yang sedang login
        $companyProfile = auth()->user()->companyProfile;

        if (!$companyProfile) {
            return redirect()->route('company.profile.edit')->with('warning', 'Harap lengkapi profil perusahaan Anda terlebih dahulu.');
        }

        // Hitung total lowongan yang statusnya 'open' milik perusahaan ini
        $totalActiveJobs = $companyProfile->jobListings()
                                        ->where('status', 'open')
                                        ->count();
        
        // Definisikan status-status final yang tidak kita hitung sebagai pelamar aktif
        $finalStatuses = ['Accepted', 'Rejected'];

        // Hitung semua pelamar yang statusnya BUKAN bagian dari status final
        $totalNewApplicants = JobApplication::whereHas('jobListing', function ($query) use ($companyProfile) {
                                    $query->where('company_profile_id', $companyProfile->id);
                                })
                                ->whereNotIn('status', $finalStatuses)
                                ->count();
        
        return view('company.dashboard', [
            'totalActiveJobs' => $totalActiveJobs,
            'totalNewApplicants' => $totalNewApplicants
        ]);
    }
    
    // === METHOD UNTUK MENAMPILKAN HALAMAN PROFIL ===
    public function editProfile()
    {
        // Ambil profil perusahaan dari user yang sedang login
        $profile = auth()->user()->companyProfile;

        // Tampilkan view dan kirim data profil ke dalamnya
        return view('company.profile', ['profile' => $profile]);
    }

    // === METHOD UNTUK MEMPERBARUI PROFIL ===
    public function updateProfile(Request $request)
    {
        // 1. Ambil profil perusahaan saat ini
        $profile = auth()->user()->companyProfile;

        // 2. Validasi data yang masuk
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
        ]);

        // 3. Handle upload logo jika ada
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($profile->logo) {
                Storage::disk('public')->delete($profile->logo);
            }
            // Simpan logo baru dan dapatkan path-nya
            $path = $request->file('logo')->store('logos', 'public');
            $validatedData['logo'] = $path;
        }

        // 4. Update data di database
        $profile->update($validatedData);

        // 5. Kembali ke halaman profil dengan pesan sukses
        return redirect()->route('company.profile.edit')->with('status', 'Profil berhasil diperbarui!');
    }
    
    public function jobs()
    {
        $jobs = auth()->user()->companyProfile->jobListings()->latest()->get();
        return view('company.jobs', ['jobs' => $jobs]);
    }

    public function applicants(JobListing $jobListing)
    {
        // Otorisasi: Pastikan perusahaan hanya bisa melihat pelamar di lowongan mereka sendiri
        $this->authorize('view', $jobListing);

        $applicants = $jobListing->jobApplications()->with('seekerProfile.user')->latest()->get();
        return view('company.applicants', [
            'job' => $jobListing,
            'applicants' => $applicants
        ]);
    }
}
