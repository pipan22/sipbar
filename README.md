# SIPBAR - Sistem Peminjaman Barang Kampus

SIPBAR adalah sistem informasi berbasis web untuk mengelola peminjaman dan pengembalian barang di lingkungan universitas. Sistem ini mendukung multi-role (Admin, Pegawai, Mahasiswa) dan dilengkapi fitur verifikasi peminjaman, stok otomatis, denda otomatis, serta laporan PDF.

---

## Fitur Utama

### 1. Multi-Role Authentication

- Admin — kelola master data, verifikasi peminjaman
- Pegawai — serah terima barang, terima pengembalian
- Mahasiswa — ajukan peminjaman, lihat riwayat

### 2. Manajemen Data

- CRUD Barang (dengan kategori, stok, ruangan)
- CRUD Ruangan (dengan pegawai penanggung jawab)
- CRUD Pegawai & Pengguna
- Manajemen Kategori Barang

### 3. Transaksi Peminjaman

- Peminjaman multi-barang dalam satu transaksi
- Verifikasi peminjaman (approve/reject oleh admin)
- Serah terima barang (oleh pegawai)
- Pengembalian + cek kondisi
- Stok otomatis berkurang saat serah terima & bertambah saat pengembalian
- Denda otomatis Rp 5.000/hari keterlambatan
- Status otomatis (menunggu, disetujui, dipinjam, dikembalikan, terlambat, ditolak)

### 4. Laporan

- Laporan Peminjaman (PDF)
- Laporan Pengembalian + Total Denda (PDF)
- Laporan Stok Barang (PDF)
- Dashboard statistik

---

## Tech Stack

| Teknologi         | Versi       |
| ----------------- | ----------- |
| Laravel           | 13.x        |
| PHP               | 8.5         |
| MySQL             | 8.0         |
| DomPDF            | Laporan PDF |
| Font Awesome      | 6.5         |
| Plus Jakarta Sans | Font utama  |

---

## Cara Install

1. Clone repository

```bash
git clone https://github.com/pipan22/sipbar.git
cd sipbar
```

2. Install dependencies

```bash
composer install
npm install
```

3. Copy file environment

```bash
cp .env.example .env
```

4. Generate application key

```bash
php artisan key:generate
```

5. Buat database baru di MySQL dengan nama `sipbar`.

6. Buka file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipbar
DB_USERNAME=root
DB_PASSWORD=
```

7. Jalankan migrasi beserta seeder data contoh:

```bash
php artisan migrate --seed
```

8. Jalankan server lokal

```bash
php artisan serve
```

9. Buka `http://127.0.0.1:8000` di browser.
