<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Halaman pilih laporan
     */
    public function index()
    {
        $totalPeminjaman = Peminjaman::count();
        $totalPengembalian = Pengembalian::count();
        $peminjamanAktif = Peminjaman::where('status_pinjam', '!=', 'kembali')->count();
        $totalDenda = Pengembalian::sum('denda');

        return view('laporan.index', compact(
            'totalPeminjaman',
            'totalPengembalian',
            'peminjamanAktif',
            'totalDenda'
        ));
    }

    /**
     * Cetak laporan peminjaman (PDF)
     */
    public function peminjaman(Request $request)
    {
        $query = Peminjaman::with('pengguna', 'pegawai', 'detail.barang');

        // Filter tanggal
        if ($request->filled('dari')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->sampai);
        }
        // Filter status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status_pinjam', $request->status);
        }

        $peminjaman = $query->orderBy('tanggal_pinjam', 'desc')->get();

        $data = [
            'judul' => 'Laporan Peminjaman Barang',
            'peminjaman' => $peminjaman,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'status' => $request->status ?? 'semua',
            'tanggal_cetak' => Carbon::now()->format('d F Y H:i'),
        ];

        $pdf = Pdf::loadView('laporan.pdf.peminjaman', $data)
                   ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-peminjaman-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Cetak laporan pengembalian (PDF)
     */
    public function pengembalian(Request $request)
    {
        $query = Pengembalian::with('peminjaman.pengguna', 'pegawai');

        if ($request->filled('dari')) {
            $query->whereDate('tanggal_kembali', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_kembali', '<=', $request->sampai);
        }

        $pengembalian = $query->orderBy('tanggal_kembali', 'desc')->get();
        $totalDenda = $pengembalian->sum('denda');

        $data = [
            'judul' => 'Laporan Pengembalian Barang',
            'pengembalian' => $pengembalian,
            'totalDenda' => $totalDenda,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'tanggal_cetak' => Carbon::now()->format('d F Y H:i'),
        ];

        $pdf = Pdf::loadView('laporan.pdf.pengembalian', $data)
                   ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-pengembalian-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Cetak laporan stok barang (PDF)
     */
    public function barang()
    {
        $barang = Barang::with('kategori', 'ruangan')->get();

        $data = [
            'judul' => 'Laporan Stok Barang',
            'barang' => $barang,
            'tanggal_cetak' => Carbon::now()->format('d F Y H:i'),
        ];

        $pdf = Pdf::loadView('laporan.pdf.barang', $data)
                   ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-stok-barang-' . date('Y-m-d') . '.pdf');
    }
}