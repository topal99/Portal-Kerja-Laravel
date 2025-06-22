<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Register - {{ config('app.name', 'Laravel') }}</title>

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

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input id="name" class="form-control form-control-lg @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input id="email" class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required>
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

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                                <input id="password_confirmation" class="form-control form-control-lg" type="password" name="password_confirmation" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Daftar Sebagai</label>
                                <div class="form-check">
                                    <input class="form-check-input @error('role') is-invalid @enderror" type="radio" name="role" id="roleSeeker" value="seeker" {{ old('role', 'seeker') == 'seeker' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="roleSeeker">Pencari Kerja</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('role') is-invalid @enderror" type="radio" name="role" id="roleCompany" value="company" {{ old('role') == 'company' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="roleCompany">Perusahaan</label>
                                </div>
                                @error('role')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    {{ __('Register') }}
                                </button>
                            </div>

                            <div class="text-center mt-4">
                                <p class="text-muted">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
                            </div>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>