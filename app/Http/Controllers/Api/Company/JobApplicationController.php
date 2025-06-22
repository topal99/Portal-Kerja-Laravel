<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request, JobApplication $application)
    {
        $this->authorize('update', $application); // Gunakan Policy yang sama

        $validated = $request->validate([
            'status' => 'required|string|in:viewed,accepted,rejected',
        ]);

        $application->update(['status' => $validated['status']]);

        // Anda bisa membuat JobApplicationResource jika perlu, atau kembalikan response sederhana
        return response()->json([
            'message' => 'Status lamaran berhasil diperbarui.',
            'application' => $application->fresh(), // Kirim data terbaru
        ]);
    }
}
