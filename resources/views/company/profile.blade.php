<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Perusahaan') }}
        </h2>
    </x-slot>

    {{-- Gunakan container Bootstrap untuk mengatur layout --}}
    <div class="container py-5">

        {{-- Notifikasi Sukses --}}
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Gunakan Card Bootstrap sebagai pembungkus utama form --}}
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <form method="POST" action="{{ route('company.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Gunakan Grid System Bootstrap untuk membuat 2 kolom --}}
                        {{-- ===== KOLOM KIRI: INFORMASI UTAMA (Lebih Lebar) ===== --}}

                            <div class="mb-4">
                                <label for="company_name" class="form-label">Nama Perusahaan</label>
                                <input type="text" class="form-control form-control-lg" id="company_name" name="company_name" value="{{ old('company_name', $profile->company_name) }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="website" class="form-label">Website</label>
                                <input type="url" class="form-control" id="website" name="website" value="{{ old('website', $profile->website) }}" placeholder="https://www.perusahaan.com">
                            </div>

                            <div class="mb-4">
                                <label for="address" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="address" name="address" rows="4">{{ old('address', $profile->address) }}</textarea>
                            </div>

                        {{-- ===== KOLOM KANAN: BRANDING & DESKRIPSI ===== --}}
                            <div class="mb-4">
                                <label for="logo" class="form-label">Logo Perusahaan</label>
                                @if ($profile->logo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $profile->logo) }}" alt="Logo saat ini" class="img-thumbnail" width="120">
                                    </div>
                                @endif
                                <input class="form-control" type="file" id="logo" name="logo">
                                <div class="form-text">Kosongkan jika tidak ingin mengganti logo.</div>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">Deskripsi Perusahaan</label>
                                <textarea class="form-control" id="description" name="description" rows="6">{{ old('description', $profile->description) }}</textarea>
                            </div>
                    </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg">Simpan Perubahan</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>