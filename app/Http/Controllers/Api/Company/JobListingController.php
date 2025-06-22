<?php

namespace App\Http\Controllers\Api\Company; // <-- PERHATIKAN, ADA 'Api' DI SINI

use App\Http\Controllers\Controller;
use App\Http\Resources\JobListingResource;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();
        if ($user->role !== 'company' || !$user->companyProfile) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string|in:Full-time,Part-time,Contract,Internship',
            'salary_range' => 'nullable|string|max:255',
            'description' => 'required|string',
        ]);

        $job = $user->companyProfile->jobListings()->create($validated);

        return (new JobListingResource($job))
                ->response()
                ->setStatusCode(201);
    }
}