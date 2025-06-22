<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Lowongan Saya') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Daftar Lowongan yang Anda Posting
                    <a href="{{ route('company.jobs.create') }}" class="btn btn-primary">Buat Lowongan Baru</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Posisi</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Jumlah Pelamar</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jobs as $job)
                                    <tr>
                                        <td>
                                            <strong>{{ $job->title }}</strong><br>
                                            <small class="text-muted">{{ $job->location }}</small>
                                        </td>
                                        <td class="text-center align-middle">
                                            @if($job->status == 'open')
                                                <span class="badge bg-success">Dibuka</span>
                                            @else
                                                <span class="badge bg-secondary">Ditutup</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="badge bg-info">{{ $job->jobApplications->count() }} Pelamar</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="{{ route('company.jobs.applicants', $job) }}" class="btn btn-sm btn-dark">Lihat Pelamar</a>
                                            <a href="{{ route('company.jobs.edit', $job) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('company.jobs.destroy', $job) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus lowongan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Anda belum memposting lowongan apapun.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>