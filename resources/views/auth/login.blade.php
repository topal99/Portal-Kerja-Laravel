<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login - {{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
        
        {{-- CSS Kustom untuk Halaman Auth --}}
        <style>
            .auth-bg-image {
                background-image: url("{{ asset('images/bg-login.jpg') }}");
                background-size: cover;
                background-position: center;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row g-0 min-vh-100">
                <div class="col-md-7 col-lg-8 d-none d-md-block auth-bg-image">
                    {{-- Anda bisa menambahkan overlay atau teks di sini jika mau --}}
                </div>

                <div class="col-md-5 col-lg-4 d-flex align-items-center justify-content-center py-5">
                    <div class="w-100" style="max-width: 400px;">
                        <div class="text-center mb-4">
                            <a href="/">
                                <x-application-logo width="80" height="80"/>
                            </a>
                            <h3 class="mt-3">Selamat Datang Kembali</h3>
                            <p class="text-muted">Silakan masuk untuk melanjutkan.</p>
                        </div>

                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input id="email" class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                    <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="small" href="{{ route('password.request') }}">
                                        {{ __('Lupa password?') }}
                                    </a>
                                @endif
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    {{ __('Log in') }}
                                </button>
                            </div>

                            <div class="text-center mt-4">
                                <p class="text-muted">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>