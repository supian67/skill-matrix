SISTEM ASSESSMENT SKILL MATRIX KARYAWAN — STARTER LARAVEL 13
===========================================================

Paket ini adalah starter source code untuk dipasang ke project Laravel 13 baru.
Tidak menyertakan folder vendor Laravel; instal Laravel melalui Composer terlebih dahulu.

FITUR AWAL
- Dashboard HRM dengan kartu KPI, grafik ringkas, distribusi kompetensi, dan daftar skill.
- Sidebar: Dashboard, Master Data (Departemen, Jabatan, Skill), Karyawan, Assessment,
  Skill Gap Analysis, Training, Laporan, Pengaturan.
- CRUD dasar karyawan, skill, dan assessment.
- Skala penilaian 1–5 dan status kompetensi.
- Filter laporan dan tombol cetak browser.
- Blade layout responsif dengan tampilan terinspirasi referensi HRM Mitra.

PERSIAPAN
1. Pastikan PHP memenuhi persyaratan Laravel 13 yang dipakai pada project Anda.
2. Buat project:
   composer create-project laravel/laravel:^13.0 skill-matrix
3. Ekstrak paket ini, lalu salin isi folder app/, database/, resources/, routes/ ke project.
   Jika ada file dengan nama sama, backup dan gabungkan dengan hati-hati.
4. Buat database MySQL melalui phpMyAdmin, misalnya skill_matrix.
5. Atur .env:
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=skill_matrix
   DB_USERNAME=root
   DB_PASSWORD=
6. Jalankan:
   php artisan key:generate
   php artisan migrate --seed
   php artisan serve
7. Buka http://127.0.0.1:8000

CATATAN
- Ini starter aplikasi, bukan project Laravel lengkap berisi vendor/bootstrapping.
- Belum termasuk autentikasi dan role-permission. Tambahkan Laravel Breeze/Fortify
  sebelum digunakan di lingkungan produksi.
- Nilai dashboard contoh berasal dari data database dan/atau data demo seeder.
- Skala assessment 1–5: 1 Pemula, 2 Dasar, 3 Menengah, 4 Mahir, 5 Ahli.
- Uji migrasi di database pengembangan terlebih dahulu.
