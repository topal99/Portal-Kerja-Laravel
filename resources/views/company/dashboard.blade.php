<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Perusahaan') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            {{-- Kartu Statistik --}}
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="card text-center text-white" style="background-color: #0d6efd;">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-briefcase-fill me-2"></i>Total Lowongan Aktif</h5>
                            <p class="display-4 fw-bold">{{ $totalActiveJobs }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-center text-dark" style="background-color: #ffc107;">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-person-fill me-2"></i>Pelamar Baru Menunggu Respon</h5>
                            <p class="display-4 fw-bold">{{ $totalNewApplicants }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Aksi Cepat --}}
            <div class="card">
                <div class="card-header">
                    Aksi Cepat
                </div>
                <div class="card-body">
                    <p>Kelola lowongan dan profil perusahaan Anda dengan mudah.</p>
                    <a href="{{ route('company.jobs.create') }}" class="btn btn-primary">Buat Lowongan Baru</a>
                    <a href="{{ route('company.jobs') }}" class="btn btn-secondary">Lihat Semua Lowongan</a>
                    <a href="{{ route('company.profile.edit') }}" class="btn btn-outline-dark">Edit Profil Perusahaan</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>