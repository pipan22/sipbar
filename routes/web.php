<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;

// ===== LANDING PAGE =====
Route::get('/', function () {
    return view('landing');
})->name('landing');

// ===== AUTH =====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== MAHASISWA ONLY =====
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Mahasiswa\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/katalog', [\App\Http\Controllers\Mahasiswa\KatalogController::class, 'index'])->name('katalog');
    Route::get('/peminjaman', [\App\Http\Controllers\Mahasiswa\PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [\App\Http\Controllers\Mahasiswa\PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [\App\Http\Controllers\Mahasiswa\PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/{id}', [\App\Http\Controllers\Mahasiswa\PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::delete('/peminjaman/{id}/batal', [\App\Http\Controllers\Mahasiswa\PeminjamanController::class, 'batal'])->name('peminjaman.batal');
});

// ===== ADMIN + PEGAWAI (Shared) =====
Route::middleware(['auth', 'role:admin,pegawai'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::resource('pengembalian', PengembalianController::class);
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/peminjaman/form', [LaporanController::class, 'peminjamanForm'])->name('laporan.peminjaman.form');
    Route::get('/laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
    Route::get('/laporan/pengembalian/form', [LaporanController::class, 'pengembalianForm'])->name('laporan.pengembalian.form');
    Route::get('/laporan/pengembalian', [LaporanController::class, 'pengembalian'])->name('laporan.pengembalian');
    Route::get('/laporan/barang', [LaporanController::class, 'barang'])->name('laporan.barang');
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
});

// ===== ADMIN ONLY =====
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('barang', BarangController::class)->except(['index']);
    Route::resource('ruangan', RuanganController::class)->except(['index']);
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('pengguna', PenggunaController::class);
    Route::resource('peminjaman', PeminjamanController::class)->except(['index', 'show']);
    Route::post('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
});

// ===== PEGAWAI ONLY =====
Route::middleware(['auth', 'role:pegawai'])->group(function () {
    Route::post('/peminjaman/{id}/serah-terima', [PeminjamanController::class, 'serahTerima'])->name('peminjaman.serah');
    Route::post('/peminjaman/{id}/terima-kembali', [PeminjamanController::class, 'terimaKembali'])->name('peminjaman.terima');
});