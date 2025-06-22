@php
    $isHomePage = request()->routeIs('home');
@endphp

{{-- Jika ini adalah halaman utama, gunakan navbar transparan --}}
@if ($isHomePage)
<nav class="navbar navbar-expand-lg navbar-dark navbar-transparent">    
    <div class="container">
        <a class="navbar-brand" href="/">
            <x-application-logo width="36" height="36" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                    {{-- Navigasi jika SUDAH LOGIN --}}
                    @if(auth()->user()->role === 'seeker')
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('seeker.dashboard') ? 'active' : '' }}" href="{{ route('seeker.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('seeker.applications') ? 'active' : '' }}" href="{{ route('seeker.applications') }}">Riwayat Lamaran</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('seeker.profile.edit') ? 'active' : '' }}" href="{{ route('seeker.profile.edit') }}">Profil Saya</a></li>
                    @elseif(auth()->user()->role === 'company')
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('company.dashboard') ? 'active' : '' }}" href="{{ route('company.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('company.jobs*') ? 'active' : '' }}" href="{{ route('company.jobs') }}">Manajemen Lowongan</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('company.profile.edit') ? 'active' : '' }}" href="{{ route('company.profile.edit') }}">Profil Perusahaan</a></li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                 @guest
                    {{-- Navigasi jika BELUM LOGIN (Tamu) --}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Daftar</a>
                    </li>
                @else
                    {{-- Dropdown jika SUDAH LOGIN --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            {{-- Kita hapus link ke profile.edit karena sudah ada link yang lebih spesifik di navigasi utama --}}
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        Log Out
                                    </button>
                                </form>
                            </li>
                        </ul>

                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
@else

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand" href="/">
            <x-application-logo width="36" height="36" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                    {{-- Navigasi jika SUDAH LOGIN --}}
                    @if(auth()->user()->role === 'seeker')
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('seeker.dashboard') ? 'active' : '' }}" href="{{ route('seeker.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('seeker.applications') ? 'active' : '' }}" href="{{ route('seeker.applications') }}">Riwayat Lamaran</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('seeker.profile.edit') ? 'active' : '' }}" href="{{ route('seeker.profile.edit') }}">Profil Saya</a></li>
                    @elseif(auth()->user()->role === 'company')
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('company.dashboard') ? 'active' : '' }}" href="{{ route('company.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('company.jobs*') ? 'active' : '' }}" href="{{ route('company.jobs') }}">Manajemen Lowongan</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('company.profile.edit') ? 'active' : '' }}" href="{{ route('company.profile.edit') }}">Profil Perusahaan</a></li>
                    @endif
                @endauth
                {{-- Navigasi jika belum LOGIN --}}
                @guest
                        <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                        </li>
                @endguest
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                 @guest
                    {{-- Navigasi jika BELUM LOGIN (Tamu) --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Daftar</a>
                    </li>
                @else
                    {{-- Dropdown jika SUDAH LOGIN --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            {{-- Kita hapus link ke profile.edit karena sudah ada link yang lebih spesifik di navigasi utama --}}
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        Log Out
                                    </button>
                                </form>
                            </li>
                        </ul>

                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
@endif