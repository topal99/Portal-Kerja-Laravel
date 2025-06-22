<?php

namespace App\Http\Controllers\Company; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobListing;

class JobListingController extends Controller
{
    // Menampilkan form untuk membuat lowongan baru
    public function create()
    {
        return view('company.jobs.create');
    }

    // Menyimpan lowongan baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string|in:Full-time,Part-time,Contract,Internship',
            'salary_range' => 'nullable|string|max:255',
            'description' => 'required|string',
            'education_level' => 'required|in:SMA/SMK,D3,S1,S2,S3',
            'experience_years' => 'required|integer|min:0|max:50',
        ]);

        $companyProfile = auth()->user()->companyProfile;
        $companyProfile->jobListings()->create($validated);

        return redirect()->route('company.jobs')->with('success', 'Lowongan pekerjaan berhasil diposting!');
    }

    // Menampilkan form edit
    public function edit(JobListing $jobListing)
    {
        $this->authorize('update', $jobListing); // Cek izin sebelum menampilkan form
        return view('company.jobs.edit', ['job' => $jobListing]);
    }

    // Memproses update
    public function update(Request $request, JobListing $jobListing)
    {
        $this->authorize('update', $jobListing); // Cek izin sebelum update

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string|in:Full-time,Part-time,Contract,Internship',
            'salary_range' => 'nullable|string|max:255',
            'description' => 'required|string',
        ]);

        $jobListing->update($validated);
        return redirect()->route('company.jobs')->with('success', 'Lowongan berhasil diperbarui.');
    }

    // Menghapus lowongan
    public function destroy(JobListing $jobListing)
    {
        $this->authorize('delete', $jobListing); // Cek izin sebelum menghapus

        $jobListing->delete();
        return redirect()->route('company.jobs')->with('success', 'Lowongan berhasil dihapus.');
    }
}