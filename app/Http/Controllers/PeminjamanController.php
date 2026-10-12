<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Pengguna;
use App\Models\Pegawai;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
        public function index(Request $request)
{
    // Update status otomatis (kecuali kembali, menunggu, ditolak)
    Peminjaman::whereNotIn('status_pinjam', ['kembali', 'menunggu', 'ditolak'])
               ->get()
               ->each(fn($p) => $p->updateStatusOtomatis());

    $query = Peminjaman::with('pengguna', 'pegawai', 'detail.barang')
                        ->orderBy('id_peminjaman', 'desc');

    // Filter status kalau ada request
    if ($request->filled('status') && $request->status !== 'semua') {
        $query->where('status_pinjam', $request->status);
    }

    $peminjaman = $query->get();

    return view('peminjaman.index', compact('peminjaman'));
}

    public function create()
    {
        $pengguna = Pengguna::all();
        $pegawai = Pegawai::all();
        $barang = Barang::where('stok', '>', 0)->get();
        return view('peminjaman.create', compact('pengguna', 'pegawai', 'barang'));
    }

    public function store(Request $request)
{
    $request->validate([
        'id_pegawai' => 'required|exists:pegawai,id_pegawai',
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
        return back()->withErrors(['error' => 'Akun Anda belum terdaftar sebagai peminjam. Hubungi admin.']);
    }

    DB::beginTransaction();
    try {
        // Simpan peminjaman dengan status MENUNGGU
        $peminjaman = Peminjaman::create([
            'id_pengguna'    => $pengguna->id_pengguna,
            'id_pegawai'     => $request->id_pegawai,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'durasi_pinjam'  => $request->durasi_pinjam,
            'status_pinjam'  => 'menunggu',  // ← UBAH JADI MENUNGGU
        ]);

        // Simpan detail (stok BELUM dikurangi — tunggu approve)
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
            // TIDAK ada decrement stok di sini
        }

        DB::commit();

        return redirect()->route('mahasiswa.peminjaman.index')
                         ->with('success', 'Pengajuan berhasil dikirim! Menunggu verifikasi petugas.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => $e->getMessage()])->withInput();
    }
}

    public function show($id)
    {
        $peminjaman = Peminjaman::with('pengguna', 'pegawai', 'detail.barang')->findOrFail($id);
        return view('peminjaman.show', compact('peminjaman'));
    }

    /**
 * Setujui pengajuan peminjaman
 */
public function approve(Request $request, $id)
{
    $request->validate([
        'id_pegawai' => 'required|exists:pegawai,id_pegawai',
    ], [
        'id_pegawai.required' => 'Pilih petugas yang akan melayani.',
    ]);

    $peminjaman = Peminjaman::findOrFail($id);

    if ($peminjaman->status_pinjam !== 'menunggu') {
        return back()->withErrors(['error' => 'Peminjaman ini sudah diproses.']);
    }

    // Setujui + pilih petugas, stok BELUM berkurang
    $peminjaman->update([
        'status_pinjam' => 'disetujui',
        'id_pegawai'    => $request->id_pegawai,
    ]);

    return redirect()->route('peminjaman.index')
                     ->with('success', 'Peminjaman disetujui! Menunggu serah terima oleh petugas.');
}

/**
 * Tolak pengajuan peminjaman
 */
public function reject($id)
{
    $peminjaman = Peminjaman::findOrFail($id);

    if ($peminjaman->status_pinjam !== 'menunggu') {
        return back()->withErrors(['error' => 'Peminjaman ini sudah diproses.']);
    }

    $peminjaman->update(['status_pinjam' => 'ditolak']);

    return redirect()->route('peminjaman.index')
                     ->with('success', 'Peminjaman ditolak.');
}

/**
 * Petugas serah terima barang — stok berkurang di sini
 */
public function serahTerima($id)
{
    DB::beginTransaction();
    try {
        $peminjaman = Peminjaman::with('detail')->findOrFail($id);

        if ($peminjaman->status_pinjam !== 'disetujui') {
            return back()->withErrors(['error' => 'Status tidak valid. Harus "Disetujui" dulu.']);
        }

        // Cek stok
        foreach ($peminjaman->detail as $detail) {
            $barang = Barang::findOrFail($detail->id_barang);
            if ($barang->stok < $detail->jumlah) {
                throw new \Exception("Stok {$barang->nama_barang} tidak cukup. Tersisa: {$barang->stok}");
            }
        }

        // Kurangi stok
        foreach ($peminjaman->detail as $detail) {
            $barang = Barang::find($detail->id_barang);
            $barang->decrement('stok', $detail->jumlah);
        }

        $peminjaman->update(['status_pinjam' => 'dipinjam']);

        DB::commit();
        return redirect()->route('peminjaman.index')
                         ->with('success', 'Barang diserahkan! Stok berkurang.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}

/**
 * Petugas terima pengembalian — stok bertambah di sini
 */
public function terimaKembali($id)
{
    DB::beginTransaction();
    try {
        $peminjaman = Peminjaman::with('detail')->findOrFail($id);

        if (!in_array($peminjaman->status_pinjam, ['dipinjam', 'terlambat'])) {
            return back()->withErrors(['error' => 'Status tidak valid.']);
        }

        // Kembalikan stok
        foreach ($peminjaman->detail as $detail) {
            $barang = Barang::find($detail->id_barang);
            if ($barang) {
                $barang->increment('stok', $detail->jumlah);
            }
        }

        $peminjaman->update(['status_pinjam' => 'dikembalikan']);

        DB::commit();
        return redirect()->route('peminjaman.index')
                         ->with('success', 'Pengembalian diterima! Stok bertambah.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}

    public function batal($id)
{
    $pengguna = Pengguna::where('username', Auth::user()->username)->first();
    $peminjaman = Peminjaman::where('id_pengguna', $pengguna->id_pengguna)
                             ->where('status_pinjam', 'menunggu')
                             ->findOrFail($id);

    DB::beginTransaction();
    try {
        DetailPeminjaman::where('id_peminjaman', $id)->delete();
        $peminjaman->delete();
        DB::commit();

        return redirect()->route('mahasiswa.peminjaman.index')
                         ->with('success', 'Pengajuan berhasil dibatalkan.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}

    public function edit($id)
    {
        $peminjaman = Peminjaman::with('detail')->findOrFail($id);
        $pengguna = Pengguna::all();
        $pegawai = Pegawai::all();
        $barang = Barang::all();
        return view('peminjaman.edit', compact('peminjaman', 'pengguna', 'pegawai', 'barang'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'id_pengguna'    => 'required|exists:pengguna,id_pengguna',
        'id_pegawai'     => 'required|exists:pegawai,id_pegawai',
        'tanggal_pinjam' => 'required|date',
        'durasi_pinjam'  => 'nullable|integer|min:1',
        'status_pinjam'  => 'nullable|in:menunggu,disetujui,dipinjam,dikembalikan,terlambat,ditolak',
    ]);

    $peminjaman = Peminjaman::findOrFail($id);
    $peminjaman->update([
        'id_pengguna'    => $request->id_pengguna,
        'id_pegawai'     => $request->id_pegawai,
        'tanggal_pinjam' => $request->tanggal_pinjam,
        'durasi_pinjam'  => $request->durasi_pinjam,
        'status_pinjam'  => $request->status_pinjam,
    ]);

    return redirect()->route('peminjaman.index')
                     ->with('success', 'Peminjaman berhasil diperbarui!');
}

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::with('detail')->findOrFail($id);

            // Kembalikan stok barang (karena peminjaman dibatalkan)
            foreach ($peminjaman->detail as $detail) {
                $barang = Barang::find($detail->id_barang);
                if ($barang) {
                    $barang->increment('stok', $detail->jumlah);
                }
            }

            // Hapus detail dulu
            DetailPeminjaman::where('id_peminjaman', $id)->delete();
            $peminjaman->delete();

            DB::commit();

            return redirect()->route('peminjaman.index')
                             ->with('success', 'Peminjaman dihapus! Stok barang dikembalikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}