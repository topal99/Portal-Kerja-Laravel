<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\JobListing;
use Illuminate\Support\Facades\Auth; 

class DashboardController extends Controller
{
     public function index()
    {
    // Logika untuk mengambil ID lamaran (sama seperti di HomeController)
        $appliedJobIds = Auth::user()->seekerProfile
                            ->jobApplications()
                            ->pluck('job_listing_id');

        // Logika untuk mengambil data lowongan
        $jobs = JobListing::where('status', 'open')
                        ->with('companyProfile')
                        ->latest()
                        ->paginate(9);
                        
        $profile = auth()->user()->seekerProfile;
        $totalApplications = $profile->jobApplications()->count();
        $acceptedApplications = $profile->jobApplications()->where('status', 'accepted')->count();

        // Kirim semua data ke view
        return view('seeker.dashboard', [
            'jobs' => $jobs,
            'appliedJobIds' => $appliedJobIds,
            'totalApplications' => $totalApplications,
            'acceptedApplications' => $acceptedApplications,

        ]);    
    }

    // === METHOD UNTUK MENAMPILKAN HALAMAN PROFIL ===
    public function editProfile()
    {
        // Ambil profil pencari kerja dari user yang sedang login
        $profile = auth()->user()->seekerProfile;

        // Tampilkan view dan kirim data profil ke dalamnya
        return view('seeker.profile', ['profile' => $profile]);
    }

    // === METHOD UNTUK MEMPERBARUI PROFIL ===
    public function updateProfile(Request $request)
    {
        // 1. Ambil profil saat ini
        $profile = auth()->user()->seekerProfile;

        // 2. Validasi data
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'skills' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB untuk foto
            'resume_path' => 'nullable|file|mimes:pdf|max:5120',   // Maks 5MB untuk CV PDF
        ]);

        // 3. Handle upload foto profil jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama
            if ($profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }
            // Simpan foto baru
            $path = $request->file('photo')->store('photos', 'public');
            $validatedData['photo'] = $path;
        }
        
        // 4. Handle upload CV jika ada
        if ($request->hasFile('resume_path')) {
            // Hapus CV lama
            if ($profile->resume_path) {
                Storage::disk('public')->delete($profile->resume_path);
            }
            // Simpan CV baru
            $path = $request->file('resume_path')->store('resumes', 'public');
            $validatedData['resume_path'] = $path;
        }

        // 5. Update data di database
        $profile->update($validatedData);

        // 6. Kembali ke halaman profil dengan pesan sukses
        return redirect()->route('seeker.profile.edit')->with('status', 'Profil berhasil diperbarui!');
    }

    public function applications()
    {
        $applications = auth()->user()->seekerProfile
                                ->jobApplications()
                                ->with('jobListing.companyProfile') // Eager loading
                                ->latest()
                                ->get();

        return view('seeker.applications', ['applications' => $applications]);
    }
}
