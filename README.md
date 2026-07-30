# 📦 Sistem Informasi Manajemen Inventaris Hukum (Bagian Hukum Setda Kota Tegal)

[![Laravel Version](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/php-%23777BB4.svg?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/bootstrap-%237952B3.svg?style=flat-square&logo=bootstrap&logoColor=white)](https://getbootstrap.com)

Sistem Informasi Manajemen modern yang dirancang khusus untuk memenuhi standar tata kelola dan administrasi di **Bagian Hukum Sekretariat Daerah (Setda) Kota Tegal**. Sistem ini mengintegrasikan pencatatan aset daerah (KIB B - Peralatan dan Mesin), Rekapitulasi Persediaan Barang Pakai Habis secara Historis, Manajemen Arsip Dokumen Hukum Digital, hingga Kalkulator Penyusutan Aset otomatis secara terpadu.

---

## ✨ Fitur & Modul Utama (Terkini)

### 📊 Laporan Rekapitulasi Persediaan (Format SIMDA)
- **Matriks Rekapitulasi Historis**: Fitur Laporan Bulanan yang secara otomatis menghitung Saldo Bulan Lalu, Pengadaan, Pemakaian, dan Sisa Bulan Ini untuk berbagai kategori barang (ATK, Benda Pos, Cetakan Lainnya).
- **Multi-Bulan (Pemilih Bulan)**: Pengguna dapat dengan mudah memfilter dan melihat riwayat data persediaan dari bulan-bulan sebelumnya (misal: Januari, Februari, Mei 2026) melalui *Month Picker* yang terintegrasi.
- **Tampilan Presisi Tinggi (Sticky UI)**: Tabel laporan dirancang dengan teknologi *Sticky Column* dan *Sticky Header*, menjaga agar Nama Barang dan Judul Kolom tetap terlihat meski tabel (17 kolom) digeser secara horizontal.

### 📋 Manajemen Inventaris & Aset (KIB B)
- **Database Terpusat**: Pengelolaan master barang, kategori barang, dan satuan secara mudah.
- **Pencatatan Spesifik BMD**: Manajemen inventaris kendaraan, alat elektronik, dan mebeler dengan struktur kolom sesuai standar Barang Milik Daerah (BMD), lengkap dengan kode SIMDA.
- **Deteksi Anomali**: Sistem terintegrasi dengan logika *Carry-Forward* untuk memastikan sisa stok bulan berjalan sinkron dengan sisa awal bulan depan.

### 📉 Analisis Penyusutan Aset (Depresiasi)
- **Otomatisasi Masa Manfaat**: Aset Elektronik (4 tahun), Mebeler (5 tahun), dan Kendaraan (7 tahun).
- **Nilai Aset Saat Ini (Nilai Buku)**: Sistem otomatis menghitung penyusutan barang menggunakan *Straight-Line Method* (Garis Lurus) setiap bulan dari Harga Perolehan hingga mencapai target Nilai Residu di masa akhirnya.

### 📄 Arsip Dokumen Hukum Digital (Smart Search)
- Manajemen *upload* file PDF untuk berbagai instrumen regulasi (Perda, SK, Perbup).
- **Smart Parsing & Ekstraksi Teks**: Saat dokumen PDF diunggah, sistem secara otomatis mengekstraksi tanggal/tahun penetapan dari dalam dokumen (misalnya: "Ditetapkan di Tegal pada tanggal 28 November 2008").
- **Pencarian Khusus Tahun**: Dokumen arsip dapat difilter hanya dengan mengetikkan Tahun Terbit pada kolom pencarian.

### 👥 Role-Based Access Control (RBAC) & Keamanan
Sistem dirancang dengan 3 (tiga) peran otoritas utama dengan pembatasan hak akses yang ketat:
1. **Superadmin**: Memiliki hak prerogatif untuk manajemen pengguna dan konfigurasi sistem (tidak memiliki akses CRUD untuk operasional data barang).
2. **Admin Gudang (Pengurus Barang)**: Memiliki hak akses penuh (CRUD) untuk operasional harian data inventaris, mutasi barang, laporan stok, dan unggah arsip.
3. **Pimpinan**: Akses pemantauan (Read-Only) atas laporan statistik dan performa aset.

Sistem dilengkapi dengan **Halaman Penolakan Akses** berdesain kustom elegan untuk menjamin keamanan akses.

---

## 🛠️ Persyaratan Sistem (Environment)

- **PHP**: `^8.1` / `8.2`
- **Database**: MySQL `^8.0` / PostgreSQL
- **Ekstensi PHP Wajib**: `openssl`, `pdo`, `mbstring`, `gd`, `zip`
- **Perlengkapan Tambahan**: `pdftotext` (untuk ekstraksi data otomatis dari file Arsip PDF)

---

## 🚀 Panduan Instalasi Singkat

**1. Clone dan Install Dependensi**
```bash
git clone <url-repository>
cd inventaris-hukum
composer install
npm install
```

**2. Konfigurasi Lingkungan (.env)**
Salin file `.env.example` menjadi `.env`, lalu buat *application key* baru:
```bash
cp .env.example .env
php artisan key:generate
```
*(Jangan lupa menyesuaikan koneksi database Anda di dalam file `.env`)*

**3. Migrasi & Seeding Data Awal**
Perintah ini akan membuat struktur tabel beserta akun default, daftar satuan barang, data dummy, serta **Data Persediaan SIMDA (Januari, Februari, & Mei 2026)**:
```bash
php artisan migrate:fresh --seed
```

**4. Hubungkan Folder Penyimpanan Publik**
```bash
php artisan storage:link
```

**5. Build Asset & Jalankan**
```bash
npm run build
php artisan serve
```

---

## 🔐 Akun Default (Post-Seeding)
Gunakan akun ini untuk pengujian awal:
- **Superadmin**: `superadmin` (Password: `password`)
- **Admin Gudang**: `admin_gudang` (Password: `password`)
- **Pimpinan**: `pimpinan` (Password: `password`)

---

## 📝 Riwayat Pembaruan Terkini

- **Integrasi Data Historis**: Sukses memuat data SIMDA Januari & Februari 2026 ke dalam format multi-bulan (*seeder* `JanFeb2026Seeder`).
- **Optimalisasi Laporan Bulanan**: Peningkatan presisi UI menggunakan tabel dengan lebar yang disesuaikan secara dinamis, fitur kolom nama barang statis (*sticky column*), serta pemilihan filter input "Bulan".
- **Custom Error UI**: Desain antarmuka eksklusif untuk Halaman Akses Ditolak dan Halaman Tidak Ditemukan.
- **Penyempurnaan Istilah Akuntansi**: Perubahan redaksi dari "Nilai Buku" menjadi "Nilai Aset Saat Ini" untuk mempermudah pimpinan dalam membaca laporan penyusutan.
