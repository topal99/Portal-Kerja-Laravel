<?php

namespace App\Http\Controllers;

use App\Notifications\ApplicantStatusUpdated;
use App\Models\JobListing;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class JobApplicationController extends Controller
{
    public function store(Request $request, JobListing $jobListing)
    {
        // 1. Otorisasi: Pastikan yang melamar adalah 'seeker'
        if (auth()->user()->role !== 'seeker') {
            return abort(403, 'Hanya pencari kerja yang bisa melamar.');
        }

        // 2. Validasi input
        $request->validate([
            'cover_letter' => 'nullable|string',
            // Tambahkan validasi ini
            'cv_id' => [
                'required',
                // Pastikan cv_id yang dikirim ada di tabel cvs dan milik user ini
                \Illuminate\Validation\Rule::exists('cvs', 'id')->where(function ($query) {
                    $query->where('seeker_profile_id', auth()->user()->seekerProfile->id);
                }),
            ],
        ]);

        $seekerProfile = auth()->user()->seekerProfile;

        // 3. Cek apakah sudah pernah melamar di lowongan yang sama
        $alreadyApplied = JobApplication::where('seeker_profile_id', $seekerProfile->id)
                                        ->where('job_listing_id', $jobListing->id)
                                        ->exists();

        if ($alreadyApplied) {
            return redirect()->back()->with('error', 'Anda sudah pernah melamar di lowongan ini!');
        }

        // 4. Simpan lamaran ke database
        JobApplication::create([
            'job_listing_id' => $jobListing->id,
            'seeker_profile_id' => $seekerProfile->id,
            'cover_letter' => $request->cover_letter,
            'cv_id' => $request->cv_id, // <-- Tambahkan ini
            'status' => 'sent', // Status awal
        ]);

        // 5. Arahkan ke halaman riwayat lamaran dengan pesan sukses
        return redirect()->route('seeker.applications')->with('success', 'Lamaran Anda berhasil dikirim!');
    }

    /**
     * Metode untuk mengubah status lamaran oleh perusahaan.
     */
    public function updateStatus(Request $request, JobApplication $application)
    {
        // Otorisasi menggunakan Policy
        $this->authorize('update', $application);
        $allowedStatuses = ['Applied', 'Reviewed', 'Psychotest', 'Interview', 'Offering', 'Accepted', 'Rejected'];

        $validated = $request->validate([
            // Gunakan Rule::in untuk validasi dari array
            'status' => ['required', 'string', Rule::in($allowedStatuses)],
        ]);

        $oldStatus = $application->status;

        $application->update(['status' => $validated['status']]);

        // Kondisi untuk mengirim notifikasi
        if (in_array($validated['status'], ['Applied', 'Reviewed', 'Psychotest', 'Interview', 'Offering', 'Accepted', 'Rejected'])
        && $validated['status'] !== $oldStatus) {

            $applicantUser = $application->seekerProfile->user;

            // AKTIFKAN KEMBALI BARIS INI
            $applicantUser->notify(new ApplicantStatusUpdated($application->fresh()));
        }

        return redirect()->back()->with('success', 'Status pelamar berhasil diperbarui!');
    }
}
