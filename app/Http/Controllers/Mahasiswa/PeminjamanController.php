<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Pengguna;
use App\Models\Pegawai;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Riwayat peminjaman mahasiswa
     */
    public function index(Request $request)
{
    $pengguna = Pengguna::where('username', Auth::user()->username)->first();

    if (!$pengguna) {
        return view('mahasiswa.peminjaman.index', ['peminjaman' => collect()]);
    }

    // Update status otomatis (kecuali status final)
    Peminjaman::where('id_pengguna', $pengguna->id_pengguna)
              ->whereNotIn('status_pinjam', ['dikembalikan', 'menunggu', 'ditolak'])
              ->get()
              ->each(fn($p) => $p->updateStatusOtomatis());

    $query = Peminjaman::with('detail.barang', 'pegawai')
                        ->where('id_pengguna', $pengguna->id_pengguna)
                        ->orderBy('id_peminjaman', 'desc');

    // Filter status
    if ($request->filled('status') && $request->status !== 'semua') {
        $query->where('status_pinjam', $request->status);
    }

    $peminjaman = $query->get();

    return view('mahasiswa.peminjaman.index', compact('peminjaman'));
}

    /**
     * Form ajukan pinjam
     */
    public function create()
{
    $barang = Barang::where('stok', '>', 0)->get();
    return view('mahasiswa.peminjaman.create', compact('barang'));
}

    /**
     * Simpan pengajuan pinjam
     */
    public function store(Request $request)
{
    $request->validate([
        'tanggal_pinjam' => 'required|date|after_or_equal:today',
        'durasi_pinjam' => 'required|integer|min:1|max:30',
        'barang_id' => 'required|array|min:1',
        'barang_id.*' => 'required|exists:barang,id_barang',
        'jumlah' => 'required|array|min:1',
        'jumlah.*' => 'required|integer|min:1',
    ], [
        'tanggal_pinjam.after_or_equal' => 'Tanggal pinjam tidak boleh di masa lalu.',
        'barang_id.required' => 'Pilih minimal 1 barang.',
    ]);

    $pengguna = Pengguna::where('username', Auth::user()->username)->first();

    if (!$pengguna) {
        return back()->withErrors(['error' => 'Akun Anda belum terdaftar sebagai peminjam.']);
    }

    DB::beginTransaction();
    try {
        $peminjaman = Peminjaman::create([
            'id_pengguna'    => $pengguna->id_pengguna,
            'id_pegawai'     => null,  // Nanti diisi admin
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'durasi_pinjam'  => $request->durasi_pinjam,
            'status_pinjam'  => 'menunggu',
        ]);

        foreach ($request->barang_id as $index => $id_barang) {
            $jumlah = $request->jumlah[$index];
            $barang = Barang::findOrFail($id_barang);

            if ($barang->stok < $jumlah) {
                throw new \Exception("Stok {$barang->nama_barang} tidak cukup. Tersisa: {$barang->stok}");
            }

            DetailPeminjaman::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_barang'     => $id_barang,
                'jumlah'        => $jumlah,
                'kondisi_pinjam' => 'baik',
            ]);
        }

        DB::commit();
        return redirect()->route('mahasiswa.peminjaman.index')
                         ->with('success', 'Pengajuan berhasil dikirim! Menunggu verifikasi admin.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => $e->getMessage()])->withInput();
    }
}

    /**
     * Detail peminjaman
     */
    public function show($id)
    {
        $pengguna = Pengguna::where('username', Auth::user()->username)->first();
        $peminjaman = Peminjaman::with('detail.barang', 'pegawai')
                                 ->where('id_pengguna', $pengguna->id_pengguna)
                                 ->findOrFail($id);

        return view('mahasiswa.peminjaman.show', compact('peminjaman'));
    }
}