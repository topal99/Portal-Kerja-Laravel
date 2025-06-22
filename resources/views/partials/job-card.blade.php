<div class="col-md-4 mb-4">
    {{-- Tambahkan class 'border-success' dan 'border-2' jika sudah dilamar --}}
    <div class="card h-100 position-relative {{ ($appliedJobIds ?? collect())->contains($job->id) ? 'border-success border-2' : '' }}">
        
        @if(($appliedJobIds ?? collect())->contains($job->id))
            {{-- Tambahkan badge di pojok kanan atas --}}
            <span class="badge bg-success top-0 end-0 m-2 p-2" style="z-index: 10;">Sudah Dilamar</span>
        @endif

        <div class="card-body d-flex flex-column">
            <div class="d-flex align-items-center mb-3">
                @if($job->companyProfile->logo)
                    <img src="{{ asset('storage/' . $job->companyProfile->logo) }}" alt="Logo" width="50" class="me-3 rounded-circle">
                @else
                    <img src="https://via.placeholder.com/50" alt="Logo" width="50" class="me-3 rounded-circle">
                @endif
                <div>
                    <h5 class="card-title mb-0">{{ $job->title }}</h5>
                    <small class="text-muted">
                        <a href="{{ route('companies.show', $job->companyProfile) }}" class="text-decoration-none text-muted">
                            {{ $job->companyProfile->company_name }}
                        </a>
                    </small>                
                </div>
            </div>
            <p class="card-text text-muted small">
                <i class="bi bi-mortarboard-fill"></i> {{ $job->education_level }} &nbsp;&nbsp;
                <i class="bi bi-clock-history"></i> {{ $job->experience_years > 0 ? $job->experience_years . ' thn' : 'Fresh Graduate' }} &nbsp;&nbsp;
                <i class="bi bi-geo-alt-fill me-2"></i>{{ $job->location }} &nbsp;&nbsp;
                <i class="bi bi-pen-fill me-2"></i>{{ $job->job_type }}
            </p>

            <div class="mt-auto pt-3">
                <a href="{{ route('jobs.show', $job) }}" class="btn btn-primary w-100">Lihat Detail</a>
            </div>
        </div>
    </div>
</div>