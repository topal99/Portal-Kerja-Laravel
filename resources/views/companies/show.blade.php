<x-app-layout>
    <div class="container py-5">
        <div class="card shadow-sm mb-5">
            <div class="card-body p-5">
                <div class="d-flex align-items-start">
                    @if($company->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo {{ $company->company_name }}" class="img-thumbnail me-4" style="width: 150px;">
                    @else
                        <img src="https://via.placeholder.com/150" alt="Logo {{ $company->company_name }}" class="img-thumbnail me-4">
                    @endif
                    <div>
                        <h1 class="display-5">{{ $company->company_name }}</h1>
                        @if($company->website)
                            <p class="fs-5"><a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a></p>
                        @endif
                        <p class="text-muted">{{ $company->address }}</p>
                    </div>
                </div>
                <hr>
                <h4 class="mt-4">Tentang Perusahaan</h4>
                <p>{{ $company->description ?? 'Tidak ada deskripsi perusahaan.' }}</p>
            </div>
        </div>

        <h3 class="mb-4">Lowongan Aktif dari Perusahaan Ini</h3>
        <div class="row">
            @forelse ($activeJobs as $job)
                {{-- Kita gunakan kembali partial job-card yang sudah ada! --}}
                @include('partials.job-card', ['job' => $job, 'appliedJobIds' => $appliedJobIds])
            @empty
                <div class="col">
                    <div class="alert alert-secondary text-center">
                        Perusahaan ini sedang tidak memiliki lowongan aktif.
                    </div>
                </div>
            @endforelse
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $activeJobs->links() }}
        </div>
    </div>
</x-app-layout>