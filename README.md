# Sistem Monitoring Persediaan Stok Obat - Puskesmas Karang Rejo

Sistem ini dirancang untuk mempermudah pengelolaan dan pemantauan persediaan stok obat di UPT Puskesmas Karang Rejo secara efisien, akurat, dan real-time.

## Fitur Utama

- **Dashboard Informatif**: Menampilkan ringkasan total obat, stok rendah, dan riwayat transaksi terbaru.
- **Manajemen Inventaris**: Pengelolaan data obat (tambah, edit, hapus) dengan sistem kode otomatis.
- **Stok Masuk**: Pencatatan penambahan stok obat yang masuk ke gudang.
- **Stok Keluar**: Pencatatan pengurangan stok obat untuk distribusi atau penggunaan.
- **Laporan Dinamis**: Rekapitulasi transaksi masuk dan keluar berdasarkan rentang tanggal tertentu.
- **Export PDF**: Kemudahan dalam mencetak laporan bulanan atau periode tertentu ke format PDF.
- **Otentikasi Keamanan**: Sistem login yang aman untuk mencegah akses tidak sah.

## Teknologi yang Digunakan

- **Framework**: [Laravel 12](https://laravel.com)
- **Frontend**: [Tailwind CSS](https://tailwindcss.com) & [Alpine.js](https://alpinejs.dev) (TALL Stack)
- **Database**: MySQL / MariaDB
- **PDF Engine**: [Laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)
- **Icons**: [Heroicons](https://heroicons.com)

## Cara Instalasi (Clone Project)

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda:

### Prasyarat
Pastikan Anda sudah menginstal:
- PHP >= 8.2
- Composer
- Node.js & NPM
- Laragon atau XAMPP

### Langkah-langkah

1. **Clone Repositori**
   ```bash
   git clone https://github.com/username/xenna.git
   cd xenna
   ```

2. **Instal Dependensi PHP**
   ```bash
   composer install
   ```

3. **Instal Dependensi Frontend**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan sesuaikan pengaturan database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate App Key**
   ```bash
   php artisan key:generate
   ```

6. **Migrasi Database & Seeding** (Opsional jika ingin data awal)
   ```bash
   php artisan migrate --seed
   ```

7. **Storage Link** (Penting untuk menampilkan logo)
   ```bash
   php artisan storage:link
   ```

8. **Jalankan Aplikasi**
   Jalankan server Laravel:
   ```bash
   php artisan serve
   ```
   Dan jalankan Vite untuk aset frontend:
   ```bash
   npm run dev
   ```

9. **Akses Aplikasi**
   Buka browser dan akses `http://127.0.0.1:8000`

---
&copy; 2026 UPT Puskesmas Karang Rejo. Semua Hak Dilindungi.
