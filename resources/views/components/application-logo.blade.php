@php
    $isHomePage = request()->routeIs('home');
@endphp

{{-- Jika ini adalah halaman utama, gunakan navbar transparan --}}
@if ($isHomePage)
    <img class="logo-home" {{ $attributes }} src="{{ asset('storage/logos/logoku.png') }}" alt="Logo Portal Kerja">
@else
    <img {{ $attributes }} src="{{ asset('storage/logos/logos.png') }}" alt="Logo Portal Kerja">
@endif
