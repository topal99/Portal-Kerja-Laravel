<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobListingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'job_title' => $this->title,
            'job_type' => $this->job_type,
            'location' => $this->location,
            'salary' => $this->salary_range,
            'description' => $this->description,
            'posted_at' => $this->created_at->diffForHumans(),
            'company' => [
                // Cek apakah companyProfile ada sebelum mengakses propertinya
                'name' => $this->whenLoaded('companyProfile', $this->companyProfile->company_name),
                'website' => $this->companyProfile->website,
                'logo_url' => $this->whenLoaded('companyProfile', function () {
                    return $this->companyProfile->logo ? asset('storage/' . $this->companyProfile->logo) : null;
                }),
            ]
        ];
    }
}