<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController; // Ini akan kita hapus, jadi tidak perlu lagi
use App\Http\Controllers\Company\DashboardController as CompanyDashboardController;
use App\Http\Controllers\Seeker\DashboardController as SeekerDashboardController;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\Company\JobListingController as CompanyJobListingController;
use App\Http\Controllers\CompanyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTE PUBLIK ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs/{jobListing}', [HomeController::class, 'show'])->name('jobs.show');
Route::get('/companies/{companyProfile}', [CompanyController::class, 'show'])->name('companies.show');

// --- RUTE PENGARAH SETELAH LOGIN ---
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect('/admin');
    } elseif ($user->role === 'company') {
        return redirect()->route('company.dashboard');
    } elseif ($user->role === 'seeker') {
        return redirect()->route('seeker.dashboard');
    }
    return redirect('/');

})->middleware(['auth', 'verified'])->name('dashboard');

// --- GRUP RUTE UNTUK PERUSAHAAN (BUTUH LOGIN & VERIFIKASI) ---
Route::middleware(['auth', 'verified'])->prefix('company')->name('company.')->group(function () {
    Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [CompanyDashboardController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [CompanyDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/jobs', [CompanyDashboardController::class, 'jobs'])->name('jobs');
    Route::get('/jobs/create', [CompanyJobListingController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [CompanyJobListingController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{jobListing}/applicants', [CompanyDashboardController::class, 'applicants'])->name('jobs.applicants');
    Route::put('/applications/{application}/status', [JobApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    Route::get('/jobs/{jobListing}/edit', [CompanyJobListingController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{jobListing}', [CompanyJobListingController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{jobListing}', [CompanyJobListingController::class, 'destroy'])->name('jobs.destroy');
});

// --- GRUP RUTE UNTUK PENCARI KERJA (BUTUH LOGIN & VERIFIKASI) ---
Route::middleware(['auth', 'verified'])->prefix('seeker')->name('seeker.')->group(function () {
    Route::get('/dashboard', [SeekerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [SeekerDashboardController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [SeekerDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/applications', [SeekerDashboardController::class, 'applications'])->name('applications');
    // Rute melamar dipindahkan ke sini agar lebih aman dan logis
    Route::post('/jobs/{jobListing}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');
});

Route::get('/test-pexels', function () {
    // GANTI DENGAN API KEY ANDA YANG ASLI
    $apiKey = 'qYeufKXbLVmUJmm1tktqFLEiUQXiOCbMke0ZVGtwpmasaL4OsaeKL1yM'; 

    $category = 'office'; // Kategori yang ingin Anda cari
    $perPage = 1000; // Jumlah gambar yang ingin diambil

    // Mengirim request ke API Pexels
    $response = Http::withHeaders([
        'Authorization' => $apiKey
    ])->get("https://api.pexels.com/v1/search", [
        'query' => $category,
        'per_page' => $perPage
    ]);

    // Cek jika request berhasil
    if ($response->successful()) {
        $data = $response->json();

        // Tampilkan gambar-gambar yang didapat
        foreach ($data['photos'] as $photo) {
            echo "<div>";
            echo "<h3>Fotografer: {$photo['photographer']}</h3>";
            // 'medium' adalah salah satu dari banyak ukuran yang tersedia
            echo "<img src='{$photo['src']['medium']}' width='300' />"; 
            echo "<hr>";
            echo "</div>";
        }

    } else {
        // Tampilkan error jika gagal
        return "Gagal mengambil data dari Pexels. Status: " . $response->status();
    }
});


// --- RUTE AUTENTIKASI DARI BREEZE ---
require __DIR__.'/auth.php';