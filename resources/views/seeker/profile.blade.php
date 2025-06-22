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

                             {{-- Area Foto Profil --}}
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

                             <hr>

                             {{-- Area CV --}}
                             <div class="mt-4">
                                <label for="resume_path" class="form-label">Curriculum Vitae (CV)</label>
                                @if ($profile->resume_path)
                                    <div class="d-grid mb-2">
                                        {{-- Gunakan icon dari Bootstrap Icons jika Anda sudah memasangnya --}}
                                        <a href="{{ asset('storage/' . $profile->resume_path) }}" target="_blank" class="btn btn-outline-info">
                                            <i class="bi bi-file-earmark-person-fill me-2"></i>Lihat CV Saat Ini
                                        </a>
                                    </div>
                                @endif
                                <input class="form-control" type="file" id="resume_path" name="resume_path">
                                <div class="form-text">Hanya file PDF, maks 5MB.</div>
                             </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg">Simpan Perubahan</button>
                        </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>