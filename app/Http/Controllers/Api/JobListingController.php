<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobListingResource; // <-- Pastikan ini di-import
use App\Models\JobListing;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function index()
    {
        $jobs = JobListing::where('status', 'open')->with('companyProfile')->latest()->paginate(10);
        return JobListingResource::collection($jobs);
    }

    public function show(JobListing $jobListing)
    {
        // Pastikan relasi sudah dimuat untuk menghindari query tambahan
        $jobListing->load('companyProfile'); 
        
        // Pastikan mengembalikan Resource
        return new JobListingResource($jobListing);
    }
}