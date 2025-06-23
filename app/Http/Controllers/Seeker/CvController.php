<?php
namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CvController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file_name' => 'required|string|max:255',
            'cv_file' => 'required|file|mimes:pdf|max:5120', // PDF, maks 5MB
        ]);

        $profile = auth()->user()->seekerProfile;
        $path = $request->file('cv_file')->store('resumes', 'public');

        $profile->cvs()->create([
            'file_name' => $request->file_name,
            'file_path' => $path,
        ]);

        return redirect()->route('seeker.profile.edit')->with('success', 'CV baru berhasil diunggah!');
    }

    public function destroy(Cv $cv)
    {
        // Otorisasi: pastikan yang menghapus adalah pemilik CV
        if ($cv->seeker_profile_id !== auth()->user()->seekerProfile->id) {
            abort(403);
        }

        // Hapus file dari storage
        Storage::disk('public')->delete($cv->file_path);
        // Hapus record dari database
        $cv->delete();

        return redirect()->route('seeker.profile.edit')->with('success', 'CV berhasil dihapus.');
    }
}
