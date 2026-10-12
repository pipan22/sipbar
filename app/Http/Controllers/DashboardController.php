<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pengguna;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalPengguna = Pengguna::count();
        $peminjamanAktif = Peminjaman::where('status_pinjam', 'dipinjam')->count();
        $totalPeminjaman = Peminjaman::count();

        $peminjamanTerbaru = Peminjaman::with('pengguna')
                                        ->orderBy('id_peminjaman', 'desc')
                                        ->limit(5)
                                        ->get();

        return view('dashboard', compact(
            'totalBarang',
            'totalPengguna',
            'peminjamanAktif',
            'totalPeminjaman',
            'peminjamanTerbaru'
        ));
    }
}