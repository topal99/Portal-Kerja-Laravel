<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Lowongan: {{ $job->title }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('company.jobs.update', $job) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Posisi</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $job->title)  }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Lokasi</label>
                            <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $job->location)  }}" required>
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
                            <input type="text" name="salary_range" id="salary_range" class="form-control" value="{{ old('salary_range', $job->salary_range)  }}">
                        </div>
                         <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Pekerjaan</label>
                            <textarea name="description" id="description" class="form-control" rows="6" required>{{ old('description', $job->description)  }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>