<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data pengguna yang login (by username)
        $pengguna = Pengguna::where('username', Auth::user()->username)->first();

        if (!$pengguna) {
            // Kalau belum terdaftar di tabel pengguna, tampil kosong
            return view('mahasiswa.dashboard', [
                'pengguna' => null,
                'totalPeminjaman' => 0,
                'aktif' => 0,
                'terlambat' => 0,
                'dikembalikan' => 0,
                'peminjamanTerbaru' => collect(),
            ]);
        }

        $peminjaman = Peminjaman::where('id_pengguna', $pengguna->id_pengguna);

        $totalPeminjaman = $peminjaman->count();
        $aktif = (clone $peminjaman)->where('status_pinjam', 'dipinjam')->count();
        $terlambat = (clone $peminjaman)->where('status_pinjam', 'terlambat')->count();
        $dikembalikan = (clone $peminjaman)->where('status_pinjam', 'kembali')->count();

        $peminjamanTerbaru = Peminjaman::with('detail.barang', 'pegawai')
                                        ->where('id_pengguna', $pengguna->id_pengguna)
                                        ->orderBy('id_peminjaman', 'desc')
                                        ->limit(5)
                                        ->get();

        return view('mahasiswa.dashboard', compact(
            'pengguna',
            'totalPeminjaman',
            'aktif',
            'terlambat',
            'dikembalikan',
            'peminjamanTerbaru'
        ));
    }
}