<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pelamar untuk: {{ $job->title }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="mb-3">
                <a href="{{ route('company.jobs') }}" class="btn btn-light"> &laquo; Kembali ke Daftar Lowongan</a>
            </div>

            <div class="card">
                <div class="card-header">
                    Daftar Pelamar
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Pelamar</th>
                                    <th>Tanggal Melamar</th>
                                    <th class="text-center">Status Lamaran</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- BAGIAN 1: Loop HANYA untuk membuat baris tabel (tr) --}}
                                @forelse ($applicants as $application)
                                    <tr>
                                        <td>{{ $application->seekerProfile->full_name }}</td>
                                        <td>{{ $application->created_at->format('d M Y, H:i') }}</td>
                                        <td class="text-center align-middle">
                                            @switch($application->status)
                                                @case('Psychotest')
                                                    <span class="badge bg-success text-capitalize">Tes Psikotes</span>
                                                    @break
                                                @case('Interview')
                                                    <span class="badge bg-success text-capitalize">Wawancara HRD</span>
                                                    @break
                                                @case('Offering')
                                                    <span class="badge bg-success text-capitalize">Penawaran Kontrak</span>
                                                    @break
                                                @case('Accepted')
                                                    <span class="badge bg-success text-capitalize">Diterima</span>
                                                    @break
                                                @case('Applied')
                                                    <span class="badge bg-success text-capitalize">Terkirim - status awal saat seeker melamar</span>
                                                    @break
                                                @case('Rejected')
                                                    <span class="badge bg-danger text-capitalize">Ditolak</span>
                                                    @break
                                                @case('Reviewed')
                                                    <span class="badge bg-info text-capitalize">Dilihat</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary text-capitalize">Terkirim</span>
                                            @endswitch
                                        </td>
                                        <td class="text-center align-middle">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#applicantModal{{ $application->id }}">
                                                Lihat Detail
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada pelamar untuk lowongan ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN 2: Loop BARU khusus untuk membuat semua modal (setelah tabel selesai) --}}
    @foreach ($applicants as $application)
    <div class="modal fade" id="applicantModal{{ $application->id }}" tabindex="-1" aria-labelledby="applicantModalLabel{{ $application->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applicantModalLabel{{ $application->id }}">Detail Pelamar: {{ $application->seekerProfile->full_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                             @if ($application->seekerProfile->photo)
                                <img src="{{ asset('storage/' . $application->seekerProfile->photo) }}" alt="Foto Profil" class="img-thumbnail rounded-circle mb-3" width="150">
                            @else
                                <img src="https://via.placeholder.com/150" alt="Foto Profil" class="img-thumbnail rounded-circle mb-3">
                            @endif

                            @if ($application->cv)
                                <a href="{{ asset('storage/' . $application->cv->file_path) }}" target="_blank" class="btn btn-primary w-100">
                                    Download CV ({{ $application->cv->file_name }})
                                </a>
                            @else
                                <p class="text-muted">CV tidak dilampirkan.</p>
                            @endif

                        </div>
                        <div class="col-md-8">
                            <h5>Informasi Kontak</h5>
                            <p><strong>Email:</strong> {{ $application->seekerProfile->user->email }}</p>
                            <p><strong>Telepon:</strong> {{ $application->seekerProfile->phone_number ?? '-' }}</p>
                            <hr>
                            <h5>Keahlian (Skills)</h5>
                            <p>{{ $application->seekerProfile->skills ?? 'Tidak ada data keahlian.' }}</p>
                            <hr>
                            <h5>Surat Lamaran</h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    {!! nl2br(e($application->cover_letter)) ?: '<em class="text-muted">Tidak ada surat lamaran.</em>' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <form action="{{ route('company.applications.updateStatus', $application) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="input-group">
                            <select name="status" class="form-select">
                                @php
                                    $stages = ['Applied', 'Reviewed', 'Psychotest', 'Interview', 'Offering', 'Accepted', 'Rejected'];
                                @endphp
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage }}" {{ $application->status == $stage ? 'selected' : '' }}>
                                        {{-- Mengubah teks agar lebih ramah dibaca --}}
                                        @if($stage === 'Applied') Terkirim @else {{ $stage }} @endif
                                    </option>
                                @endforeach
                            </select>                            
                            <button type="submit" class="btn btn-success">Update Status</button>
                        </div>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</x-app-layout>
