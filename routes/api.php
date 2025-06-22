<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JobListingController;
use App\Http\Controllers\Api\Company\JobListingController as ApiCompanyJobListingController; // <-- Tambah import
use App\Http\Controllers\Api\Company\JobApplicationController as ApiCompanyJobApplicationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Endpoint yang memerlukan token autentikasi (Sanctum)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Grup rute yang memerlukan autentikasi Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Endpoint untuk perusahaan memposting lowongan
    Route::post('/company/jobs', [ApiCompanyJobListingController::class, 'store']);
});

// Endpoint yang terbuka untuk umum (tidak perlu login/token)
Route::get('/jobs', [JobListingController::class, 'index']);
Route::get('/jobs/{jobListing}', [JobListingController::class, 'show']);

Route::put('/company/applications/{application}/status', [ApiCompanyJobApplicationController::class, 'updateStatus']);