<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Lowongan Pekerjaan Baru') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('company.jobs.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Posisi</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="education_level" class="form-label">Minimal Pendidikan</label>
                            <select name="education_level" id="education_level" class="form-select" required>
                                @php
                                    $levels = ['SMA/SMK', 'D3', 'S1', 'S2', 'S3'];
                                @endphp
                                @foreach ($levels as $level)
                                    {{-- Untuk form edit, tambahkan kondisi 'selected' --}}
                                    <option value="{{ $level }}" {{ old('education_level', $job->education_level ?? '') == $level ? 'selected' : '' }}>
                                        {{ $level }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="experience_years" class="form-label">Minimal Pengalaman (Tahun)</label>
                            <input type="number" name="experience_years" id="experience_years" class="form-control" 
                                value="{{ old('experience_years', $job->experience_years ?? 0) }}" required min="0">
                            <small class="form-text text-muted">Isi 0 untuk Fresh Graduate.</small>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Lokasi</label>
                            <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" required>
                        </div>
                         <div class="mb-3">
                            <label for="job_type" class="form-label">Tipe Pekerjaan</label>
                            <select name="job_type" id="job_type" class="form-select" required>
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Contract">Kontrak</option>
                                <option value="Internship">Magang</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="salary_range" class="form-label">Rentang Gaji (Opsional)</label>
                            <input type="text" name="salary_range" id="salary_range" class="form-control" value="{{ old('salary_range') }}">
                        </div>
                         <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Pekerjaan</label>
                            <textarea name="description" id="description" class="form-control" rows="6" required>{{ old('description') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Posting Lowongan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>