<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    {{-- Container utama Bootstrap --}}
    <div class="container py-5">

        {{-- Notifikasi Sukses --}}
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Card untuk membungkus form dengan rapi --}}
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">

                <form method="POST" action="{{ route('seeker.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                            <div class="text-center mb-4">
                                 <label for="photo" class="form-label">Foto Profil</label>
                                 @if ($profile->photo)
                                     <img src="{{ asset('storage/' . $profile->photo) }}" alt="Foto Profil" class="img-fluid rounded-circle shadow-sm mx-auto d-block mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                 @else
                                     <div class="bg-light rounded-circle mx-auto d-flex justify-content-center align-items-center mb-3" style="width: 150px; height: 150px;">
                                        <span class="text-muted">Foto</span>
                                     </div>
                                 @endif
                                 <input class="form-control" type="file" id="photo" name="photo">
                                 <div class="form-text mt-1">Kosongkan jika tidak ingin ganti foto.</div>
                             </div>

                            <div class="mb-4">
                                <label for="full_name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control form-control-lg" id="full_name" name="full_name" value="{{ old('full_name', $profile->full_name) }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="phone_number" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $profile->phone_number) }}" placeholder="Contoh: 081234567890">
                            </div>

                            <div class="mb-4">
                                <label for="skills" class="form-label">Keahlian (Skills)</label>
                                <textarea class="form-control" id="skills" name="skills" rows="5">{{ old('skills', $profile->skills) }}</textarea>
                                <div class="form-text">Pisahkan dengan koma, contoh: Laravel, PHP, MySQL, Public Speaking</div>
                            </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg">Simpan Perubahan</button>
                        </div>
                </form>
            </div>
        </div>
                    <div class="card mt-4"> {{-- <-- Kartu baru ini berada di luar form profil --}}
                <div class="card-header">
                    Kelola CV Anda
                </div>
                <div class="card-body">
                    <h6 class="card-title">Daftar CV Tersimpan</h6>
                    <ul class="list-group mb-4">
                        @forelse (auth()->user()->seekerProfile->cvs as $cv)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>
                                    {{ $cv->file_name }}
                                </div>
                                {{-- FORM HAPUS (Form kecil di dalam list, ini tidak masalah) --}}
                                <form action="{{ route('seeker.cv.destroy', $cv) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus CV ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Anda belum mengunggah CV.</li>
                        @endforelse
                    </ul>

                    <hr>

                    <h6 class="card-title mt-4">Unggah CV Baru</h6>
                    {{-- FORM 2 DIMULAI --}}
                    <form action="{{ route('seeker.cv.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file_name" class="form-label">Beri Nama CV Anda</label>
                            <input type="text" name="file_name" id="file_name" class="form-control" placeholder="Contoh: CV untuk Posisi Backend" required>
                            <small class="form-text text-muted">Nama ini akan membantu Anda memilih CV saat melamar.</small>
                        </div>
                        <div class="mb-3">
                            <label for="cv_file" class="form-label">Pilih File CV (PDF, maks 5MB)</label>
                            <input type="file" name="cv_file" id="cv_file" class="form-control" required accept=".pdf">
                        </div>
                        <button type="submit" class="btn btn-primary">Unggah CV</button>
                    </form> {{-- <-- FORM 2 BERAKHIR DI SINI --}}
                </div>
            </div>

    </div>
</x-app-layout>
