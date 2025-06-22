@php
    $isHomePage = request()->routeIs('home');
@endphp

{{-- Jika ini adalah halaman utama, gunakan navbar transparan --}}
@if ($isHomePage)
    <a href="/" class="application-logo">PortalKerja</a>
@else
    <img {{ $attributes }} src="{{ asset('storage/logos/logos.png') }}" alt="Logo Portal Kerja">
@endif
