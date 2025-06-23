<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Proyek Portofolio: Portal Kerja Full-Stack

Sebuah aplikasi web portal kerja lengkap yang dibangun dari awal menggunakan Laravel 11 dan Bootstrap 5. Proyek ini dirancang untuk menjadi platform fungsional yang menghubungkan pencari kerja dengan perusahaan, dilengkapi dengan sistem multi-peran, panel admin yang kuat, dan arsitektur backend modern.

Proyek ini mendemonstrasikan implementasi fitur-fitur penting seperti autentikasi, otorisasi berbasis policy, manajemen data CRUD, RESTful API, hingga tugas latar belakang menggunakan queue.


## Fitur Utama

### Publik (Untuk Semua Pengunjung)
- ✅ Homepage Dinamis: Menampilkan daftar lowongan terbaru dengan pagination.
- ✅ Pencarian & Filter: Fitur pencarian berdasarkan kata kunci, lokasi, dan tipe pekerjaan.
- ✅ Halaman Detail Lowongan: Tampilan informasi lengkap pekerjaan, termasuk logo dan detail perusahaan.
- ✅ Halaman Profil Publik Perusahaan: Melihat profil detail dan semua lowongan aktif dari sebuah perusahaan.
- ✅ Desain Responsif: Tampilan optimal di berbagai perangkat (desktop, tablet, mobile).
- ✅ UI Cerdas: Memberi tanda visual pada lowongan yang sudah dilamar oleh pengguna yang sedang login.

### Pencari Kerja (Seeker)

- ✅ Autentikasi Lengkap: Alur registrasi, login, dan verifikasi email yang aman.
- ✅ Dashboard Informatif: Ringkasan statistik lamaran terkirim dan diterima.
- ✅ Manajemen Profil: Mengedit informasi pribadi, keahlian, serta mengunggah/memperbarui foto profil dan CV (PDF).
- ✅ Proses Melamar Kerja: Form lamaran interaktif (modal) dengan opsi untuk menyertakan surat lamaran (cover letter).
- ✅ Riwayat Lamaran: Melacak semua lamaran yang telah dikirim beserta status terkininya (Terkirim, Dilihat, Diterima, Ditolak).

### Perusahaan (Company)

- ✅ Autentikasi Terpisah: Alur registrasi dan login khusus untuk peran perusahaan.
- ✅ Dashboard Fungsional: Statistik kunci seperti jumlah lowongan aktif dan pelamar baru.
- ✅ Manajemen Lowongan (CRUD): Kemampuan penuh untuk membuat, melihat, mengedit, dan menghapus lowongan pekerjaan milik sendiri.
- ✅ Manajemen Pelamar: Melihat daftar pelamar untuk setiap lowongan, lengkap dengan akses ke profil, CV, dan surat lamaran mereka.
- ✅ Proses Rekrutmen: Kemampuan untuk mengubah status lamaran seorang kandidat, yang secara otomatis mengirimkan notifikasi email.

### Panel Admin (Filament)
- ✅ Dasbor Admin Terproteksi: Hanya bisa diakses oleh pengguna dengan peran admin.
- ✅ Manajemen Data Penuh (CRUD): Mengelola semua data master di aplikasi (Users, Companies, Seekers, Job Listings, dll).
- ✅ Antarmuka Modern & Reaktif yang dibangun di atas TALL Stack.

### Backend & Arsitektur

- ✅ Otorisasi Kuat: Menggunakan Laravel Policies untuk memastikan pengguna hanya bisa mengakses dan memodifikasi data yang menjadi haknya.
- ✅ RESTful API: Menyediakan endpoint API untuk data lowongan, diformat secara profesional menggunakan API Resources.
- ✅ Tugas Latar Belakang (Queues): Menggunakan sistem Queue Laravel untuk menangani pengiriman email notifikasi secara asinkron, meningkatkan performa dan responsivitas aplikasi.
- ✅ Database Seeding & Factories: Memungkinkan pengisian database dengan data palsu yang realistis untuk keperluan testing dan demonstrasi.



## Installation
### Prasyarat
- Backend: PHP 8.2+, Laravel 11
- Panel Admin: Laravel Filament 3.x
- Frontend: HTML5, CSS3, SASS, JavaScript, Bootstrap 5
- Build Tool: Vite.js
- Database: MySQL / PostgreSQL
- Lingkungan Development Lokal: Laragon, Composer, NPM, Git
- Testing Email Lokal: Mailpit

### 1. Kloning Repositori:

```bash
https://github.com/topal99/portal-kerja-laravel.git
```


### 2. Instalasi Dependensi:


```bash
composer install
npm install
```

### 3. Konfigurasi Environment:

- Salin file .env.example menjadi .env: copy .env.example .env (di Windows) atau cp .env.example .env (di Mac/Linux).
- Generate kunci aplikasi: php artisan key:generate


### 4. Konfigurasi Database:
- Buka Laragon dan buat database baru melalui HeidiSQL atau PhpMyAdmin, beri nama misalnya portal_kerja.
- Buka file .env dan sesuaikan pengaturan database Anda:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portal_kerja
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi & Seeding Database:
Perintah ini akan membuat semua tabel dan mengisinya dengan data palsu yang siap digunakan.

```bash
php artisan migrate:fresh --seed
```
- Setelah seeding, akun admin default adalah admin@gmail.com dengan password password.
- Halaman admin dapat diakses di https://127.0.0.1:8000/admin


### 6. Kompilasi Aset Frontend:
Jalankan perintah ini di satu terminal dan biarkan tetap berjalan.

```bash
npm run dev
```

### 7. Jalankan Server Development:

Buka terminal baru dan jalankan server Laravel.


```bash
php artisan serve
```

### 8. Jalankan Queue Worker:
Buka terminal baru lainnya untuk memproses tugas latar belakang seperti notifikasi email.


```bash
php artisan queue:work
```

### 9. Akses Aplikasi:

- Aplikasi Utama: http://127.0.0.1:8000
- Panel Admin: http://127.0.0.1:8000/admin
- Inbox Email Lokal (Mailpit): http://localhost:8025








## Potensi Pengembangan Selanjutnya

- Implementasi pencarian yang lebih canggih menggunakan Laravel Scout dengan driver seperti Meilisearch atau Algolia.
- Sistem langganan (subscription) untuk perusahaan yang ingin memposting lebih banyak lowongan.
- Notifikasi real-time menggunakan Laravel Reverb (WebSockets).
- Dashboard analitik untuk admin dan perusahaan.
- Deployment ke server produksi menggunakan platform seperti Render.com atau VPS dengan Laravel Forge.










## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
