<x-app-layout>
    <div class="container py-5">
        <div class="card">

            <div class="card-header bg-white p-4">
            <div class="d-flex align-items-center">
                {{-- Bagian Logo --}}
                <div class="me-4">
                    @if($job->companyProfile->logo)
                        <img src="{{ asset('storage/' . $job->companyProfile->logo) }}" alt="Logo {{ $job->companyProfile->company_name }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: contain;">
                    @else
                        {{-- Placeholder jika tidak ada logo --}}
                        <img src="https://via.placeholder.com/80" alt="Logo Placeholder" class="img-thumbnail bg-light">
                    @endif
                </div>
                {{-- Bagian Teks Judul dan Nama Perusahaan --}}
                <div>
                    <h1 class="h2 mb-1">{{ $job->title }}</h1>
                    <h5 class="fw-normal text-muted">
                        <a href="{{ route('companies.show', $job->companyProfile) }}" class="text-decoration-none">{{ $job->companyProfile->company_name }}</a>
                    </h5>                
            </div>
            </div>
        </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="mb-3">Deskripsi Pekerjaan</h4>
                        <div class="mb-4">
                            {!! $job->description !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Detail Lowongan</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong class="bi bi-mortarboard-fill"> Pendidikan :</strong>
                                        <span>Minimal {{ $job->education_level }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong class="bi bi-clock-history"> Pengalaman :</strong>
                                        <span>{{ $job->experience_years > 0 ? 'Minimal ' . $job->experience_years . ' tahun' : 'Fresh Graduate' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong class="bi bi-geo-alt-fill"> Lokasi :</strong>
                                        <span>{{ $job->location }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong class="bi bi-pen-fill"> Tipe :</strong>
                                        <span>{{ $job->job_type }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong class="bi bi-cash"> Gaji :</strong>
                                        <span>{{ $job->salary_range ?? 'Rahasia' }}</span>
                                    </li>
                                </ul>
                                
                                @auth
                                    @if(auth()->user()->role === 'seeker')
                                        @if($hasApplied)
                                            <button class="btn btn-success w-100 mt-3" disabled>
                                                <i class="bi bi-check-circle-fill"></i> Anda Sudah Melamar
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-success w-100 mt-3" data-bs-toggle="modal" data-bs-target="#applyModal">
                                                Lamar Sekarang
                                            </button>
                                        @endif
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary w-100 mt-3">Login untuk Melamar</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         {{-- Cek apakah ada lowongan terkait sebelum menampilkan section ini --}}
        @if($relatedJobs->isNotEmpty())
            <div class="related-jobs mt-5">
                <hr>
                <h3 class="mb-4">Lowongan Terkait Lainnya</h3>
                <div class="row">
                    {{-- Kita gunakan kembali partial job-card yang sudah kita buat! --}}
                    @foreach ($relatedJobs as $relatedJob)
                        @include('partials.job-card', ['job' => $relatedJob, 'appliedJobIds' => $appliedJobIds])
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyModalLabel">Lamar Posisi: {{ $job->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('seeker.jobs.apply', $job) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Anda akan melamar menggunakan profil dan CV yang sudah Anda unggah. Anda bisa menambahkan surat lamaran singkat di bawah ini.</p>
                        <div class="mb-3">
                            <label for="cover_letter" class="form-label">Surat Lamaran (Opsional)</label>
                            <textarea class="form-control" name="cover_letter" id="cover_letter" rows="8">{{ old('cover_letter') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim Lamaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>