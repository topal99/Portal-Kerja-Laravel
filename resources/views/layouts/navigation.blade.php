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
                    {{-- Link Navigasi Berdasarkan Peran --}}
                    @if(auth()->user()->role === 'seeker')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('seeker.dashboard') ? 'active' : '' }}" href="{{ route('seeker.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('seeker.profile.edit') ? 'active' : '' }}" href="{{ route('seeker.profile.edit') }}">Profil Saya</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('seeker.applications') ? 'active' : '' }}" href="{{ route('seeker.applications') }}">Riwayat Lamaran</a>
                        </li>

                   @elseif(auth()->user()->role === 'company')
                        {{-- Link ke Dashboard --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('company.dashboard') ? 'active' : '' }}" href="{{ route('company.dashboard') }}">Dashboard</a>
                        </li>
                        {{-- Link ke Manajemen Lowongan --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('company.jobs*') ? 'active' : '' }}" href="{{ route('company.jobs') }}">Manajemen Lowongan</a>
                        </li>
                        {{-- Link ke Profil Perusahaan --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('company.profile.edit') ? 'active' : '' }}" href="{{ route('company.profile.edit') }}">Profil Perusahaan</a>
                        </li>
                    @endif
                @endauth
            </ul>

            @auth
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Pengaturan Akun</a></li>
                        <li><hr class="dropdown-divider"></li>
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
            </ul>
            @endauth
        </div>
    </div>
</nav>