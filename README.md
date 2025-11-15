# Hasi Lab Digital

![Build](https://img.shields.io/badge/build-passing-brightgreen) ![Laravel](https://img.shields.io/badge/framework-Laravel-red) ![PHP](https://img.shields.io/badge/php-8.2-blue) ![License](https://img.shields.io/badge/license-MIT-yellow) ![Database](https://img.shields.io/badge/database-MySQL-lightgrey)

**Laravel · PHP · MySQL · Tailwind · Alpine.js · MIT License**

Hasi Lab Digital adalah platform manajemen hasil laboratorium yang fokus pada alur pasien, laboratorium, dokter, dan admin. Dibangun dengan Laravel 12, menyajikan antarmuka modern dengan Tailwind CSS & Alpine.js, serta memastikan data klinis terekam dengan baik dalam MySQL.

## Navigasi Cepat 📚

- **✨ Fitur utama**: daftar pemeriksaan, status lab, notifikasi, dashboard statistik  
- **🚀 Instalasi**: `composer install` → `npm install` → copy `.env.example` → migrasi & seed  
- **📘 Dokumentasi**: penjelasan ERD, DFD, Alur Notifikasi, Integrasi role-based  
- **🎬 Demo**: gunakan akun seeded pasien/dokter/lab/admin  
- **🤝 Kontribusi**: fork → branch fitur → pull request  
- **🎨 Ikon & Layout**: antarmuka dengan badge, tombol, dan kartu responsif bergradasi.

## Tentang Proyek 🧬

Hasi Lab Digital dirancang untuk mengelola siklus hidup pemeriksaan laboratorium di rumah sakit/klinik:

✅ Tracking hasil lab dari input sampai review dokter  
✅ Manajemen status (pending, reviewed, completed) dengan badge warna  
✅ Modul notifikasi (email/web) untuk pasien dan dokter  
✅ Dashboard kosakata untuk admin/pasien mencakup statistik, aktivitas, dan quick action  
✅ Role-based access (Pasien, Admin, Dokter, Laboratorium)  
✅ Form unggah file hasil dengan preview dan download  
✅ Template email notifikasi (dapat ditambah sebagai job queue)

## Fitur Utama

### Pengalaman Pasien 🩺
- Melihat daftar hasil lab  
- Mengunduh file PDF/gambar  
- Menerima notifikasi status terbaru  

### Laboratorium 🧪
- Input hasil lengkap (jenis tes, dokter, pasien)  
- Unggah file pendukung (PDF/Gambar)  
- Edit & review sebelum disetujui dokter  

### Dokter 🩹
- Meninjau hasil yang sudah direkam  
- Mengubah status menjadi `reviewed` atau `completed`  
- Otomatis menyebarkan notifikasi ke pasien dan admin  

### Admin 🧭
- Kelola pengguna (senarai pasien/dokter/petugas lab)  
- Statistik keseluruhan (total laporan, status, notifikasi)  
- Notifikasi internal & audit aktivitas

## Arsitektur & Diagram

- **ERD**: `diagrams/README.md` menyediakan diagram tabel `users`, `lab_results`, `notifications`  
- **DFD Level 0**: alur autentikasi → pemrosesan hasil → notifikasi → dashboard  
- **Use Case Diagram**: menggambarkan aktor utama dan relasi fungsional  
- Render Mermaid langsung di GitHub atau gunakan plugin Mermaid di VSCode

## Stack Teknologi

| Layer | Teknologi |
| --- | --- |
| Backend | Laravel 12, PHP 8.2 |
| Frontend | Tailwind CSS 3, Alpine.js 3, Vite 7 |
| Database | MySQL 8 / MariaDB 10.6 |
| Autentikasi | Laravel Breeze |
| Queue | Database + Redis (opsional) |
| Export | Laravel Excel, DomPDF |
| Integrasi | Notification channel (email), file storage |

## Persiapan

1. Clone repo dan masuk ke direktori  
2. Copy environment: `cp .env.example .env`  
3. Install dependencies:
   ```
   composer install
   npm install
   npm run build
   ```
4. Generate key & migrasi:
   ```
   php artisan key:generate
   php artisan migrate --seed
   ```
5. Jalankan server:
   ```
   php artisan serve
   ```

## Akun Default (Seeder)

Silakan login dengan akun seed berikut:

| Role | Email | Password |
| --- | --- | --- |
| Admin | admin@example.com | password |
| Dokter | doctor@example.com | password |
| Laboratorium | lab@example.com | password |
| Pasien | patient@example.com | password |

## Perintah Berguna

**Testing & kualitas kode**

```
php artisan test
vendor/bin/pint
```

**Queue (opsional untuk notifikasi)**

```
php artisan queue:work
```

## Dokumentasi

- `docs/` (jika ada) berisi screenshot, diagram lanjutan, panduan integrasi  
- `diagrams/README.md` menyimpan Mermaid diagram arsitektur  
- Tambah catatan di `app_summary.md` untuk coverage tambahan

## Kontribusi

1. Fork repo → `git checkout -b feature/kolom-baru`  
2. Komit perubahan → `git push origin feature/kolom-baru`  
3. Buka Pull Request  
4. Pastikan `composer test` dan `vendor/bin/pint` lulus

## Lisensi

MIT License
