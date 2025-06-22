<x-app-layout> 
    <div class="p-5 mb-4 text-center hero-section" style="background-image: url('{{ asset('images/bg-hero-home.jpg') }}');">
        <div class="container-fluid py-5" style="padding-top: 8rem !important; padding-bottom: 3rem !important;">
        
            <h1 class="display-5 fw-bold">Temukan Pekerjaan Impian Anda</h1>
            <p class="col-md-8 fs-5 mx-auto">
                Jelajahi ribuan lowongan dari perusahaan-perusahaan terbaik di Indonesia.
            </p>
        
            {{-- Form Pencarian yang Sudah Dirapikan --}}
        <div class="container"> 
            <div class="row justify-content-center mt-4">
                <div class="col-lg-11">
                    <form action="{{ route('home') }}" method="GET" class="p-3 bg-white rounded-4 shadow-sm">
                        <div class="row g-2 align-items-center">
                            <div class="col-md">
                                <input type="text" name="keyword" class="form-control form-control-lg" placeholder="Kata Kunci (e.g., Programmer, Designer)" value="{{ request('keyword') }}">
                            </div>
                            <div class="col-md">
                                <input type="text" name="location" class="form-control form-control-lg" placeholder="Lokasi (e.g., Jakarta)" value="{{ request('location') }}">
                            </div>
                            <div class="col-md">
                                <select name="job_type" class="form-select form-select-lg">
                                    <option value="">Semua Tipe Pekerjaan</option>
                                    <option value="Full-time" {{ request('job_type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="Part-time" {{ request('job_type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="Contract" {{ request('job_type') == 'Contract' ? 'selected' : '' }}>Kontrak</option>
                                    <option value="Internship" {{ request('job_type') == 'Internship' ? 'selected' : '' }}>Magang</option>
                                </select>
                            </div>
                            <div class="col-md-auto">
                                <button type="submit" class="btn btn-primary btn-lg w-100"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
                 <div class="popular-searches mt-4">
                    <span class="me-2">Pencarian Populer:</span>
                    @php
                        // Kita definisikan kota populer secara manual untuk saat ini
                        $popularCities = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Medan'];
                    @endphp

                    @foreach ($popularCities as $city)
                        <a href="{{ route('home', ['location' => $city]) }}" class="btn btn-sm btn-outline-light rounded-pill mb-1">
                            {{ $city }}
                        </a>
                    @endforeach
                </div>
        </div>
    </div>

    <div class="container">   
        @guest
        <div class="row g-4 py-5">
            <div class="col-md-6">
                <div class="p-5 border rounded-3 bg-light">
                    <i class="bi bi-person-workspace fs-1 text-primary"></i>
                    <h2 class="mt-2">Untuk Pencari Kerja</h2>
                    <p>Daftar sekarang, lengkapi profil Anda, dan temukan ratusan peluang karir yang sesuai dengan keahlian Anda.</p>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Daftar Sekarang</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-5 border rounded-3 bg-dark text-white">
                    <i class="bi bi-building-fill-add fs-1 text-warning"></i>
                    <h2 class="mt-2">Untuk Perusahaan</h2>
                    <p>Pasang lowongan pekerjaan Anda dengan mudah dan jangkau ribuan talenta berbakat di seluruh Indonesia.</p>
                    <a href="{{ route('register') }}" class="btn btn-warning">Pasang Lowongan</a>
                </div>
            </div>
        </div>
        @endguest

        <div class="py-5 text-center">
            <h2 class="mb-4">Jelajahi Berdasarkan Kategori</h2>
            <div class="row g-3">
                @php
                    // Data kategori statis untuk contoh
                    $categories = [
                        ['name' => 'Teknologi', 'icon' => 'bi-code-slash'],
                        ['name' => 'Pemasaran', 'icon' => 'bi-megaphone-fill'],
                        ['name' => 'Desain Grafis', 'icon' => 'bi-palette-fill'],
                        ['name' => 'Keuangan', 'icon' => 'bi-bank'],
                    ];
                @endphp

                @foreach ($categories as $category)
                <div class="col-md-3">
                    <a href="{{ route('home', ['keyword' => $category['name']]) }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <i class="{{ $category['icon'] }} fs-1 text-primary"></i>
                                <h5 class="mt-3">{{ $category['name'] }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <h3 class="mb-4">Lowongan Terbaru</h3>
        <div class="row">
            @forelse ($jobs as $job)
                @include('partials.job-card', ['job' => $job, 'appliedJobIds' => $appliedJobIds])
            @empty
                <div class="col">
                    <p class="text-center">Belum ada lowongan yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $jobs->links() }}
        </div>
    </div>

        <section class="testimonial-section-v2 py-5 mt-4" style="background-color:hsl(212, 100.00%, 93.30%);">
            <div class="container">
                <h2 class="text-center mb-5">Apa Kata Mereka Tentang Kami?</h2>
                
                @php
                    // Data testimoni palsu (hardcoded) - sama seperti sebelumnya
                    $testimonials = [
                        [
                            'name' => 'Sarah Larasati',
                            'role' => 'Web Developer di Tech Solutions',
                            'quote' => 'Melalui Portal Kerja, saya berhasil mendapatkan pekerjaan impian saya sebagai developer hanya dalam waktu 2 minggu! Platformnya sangat mudah digunakan dan lowongannya sangat berkualitas.',
                            'image' => 'images/testimonials/person1.jpg'
                        ],
                        [
                            'name' => 'Budi Santoso',
                            'role' => 'HR Manager di Creative Agency',
                            'quote' => 'Kami berhasil merekrut dua desainer grafis berbakat dari sini. Kualitas kandidatnya jauh di atas rata-rata platform lain. Proses posting lowongan juga sangat cepat dan efisien.',
                            'image' => 'images/testimonials/person2.jpg'
                        ],
                        [
                            'name' => 'Ahmad Fauzi',
                            'role' => 'Fresh Graduate',
                            'quote' => 'Sebagai lulusan baru, saya sempat kesulitan mencari pekerjaan pertama. Berkat filter pencarian yang canggih, saya menemukan lowongan magang di sini.',
                            'image' => 'images/testimonials/person3.jpg'
                        ]
                    ];
                @endphp

                <div class="row g-4">
                    @foreach ($testimonials as $testimonial)
                        <div class="col-lg-4 d-flex align-items-stretch">
                            <div class="card h-100 border-0 shadow-sm testimonial-card-v2">
                                <div class="card-body p-4">
                                    <div class="row">
                                        {{-- Kolom Kiri: Foto dan Profil --}}
                                        <div class="col-4 text-center d-flex flex-column align-items-center">
                                            <img src="{{ asset($testimonial['image']) }}" class="img-fluid rounded-circle mb-3" alt="Foto {{ $testimonial['name'] }}" style="width: 80px; height: 80px; object-fit: cover;">
                                            <h6 class="fw-bold mb-0">{{ $testimonial['name'] }}</h6>
                                            <small class="text-muted">{{ $testimonial['role'] }}</small>
                                        </div>
                                        
                                        {{-- Kolom Kanan: Kutipan Testimonial --}}
                                        <div class="col-8">
                                            <div class="testimonial-quote">
                                                <i class="bi bi-quote"></i>
                                                <p class="fst-italic">
                                                    {{ $testimonial['quote'] }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            <div class="container">
        </section>
    </div>
</x-app-layout>