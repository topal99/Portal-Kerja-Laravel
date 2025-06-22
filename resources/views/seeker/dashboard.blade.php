<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            {{-- Kartu Statistik --}}
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Lamaran Terkirim</h5>
                            <p class="display-4 fw-bold">{{ $totalApplications }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-center bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Lamaran Diterima</h5>
                            <p class="display-4 fw-bold">{{ $acceptedApplications }}</p>
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
                    <p>Lanjutkan perjalanan karir Anda.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Cari Lowongan Baru</a>
                    <a href="{{ route('seeker.applications') }}" class="btn btn-secondary">Lihat Riwayat Lamaran</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>