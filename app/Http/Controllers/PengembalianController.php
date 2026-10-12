<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Pegawai;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with('peminjaman.pengguna', 'pegawai')
                                     ->orderBy('id_pengembalian', 'desc')
                                     ->get();
        return view('pengembalian.index', compact('pengembalian'));
    }

    public function create()
    {
        // Hanya tampilkan peminjaman yang belum dikembalikan
        $peminjaman = Peminjaman::with('pengguna')
                                 ->where('status_pinjam', '!=', 'kembali')
                                 ->get();
        $pegawai = Pegawai::all();
        return view('pengembalian.create', compact('peminjaman', 'pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman'   => 'required|exists:peminjaman,id_peminjaman|unique:pengembalian,id_peminjaman',
            'tanggal_kembali' => 'required|date',
            'kondisi_kembali' => 'nullable|in:baik,rusak ringan,rusak berat',
            'id_pegawai'      => 'required|exists:pegawai,id_pegawai',
        ]);

        DB::beginTransaction();
        try {
            // Ambil data peminjaman
            $peminjaman = Peminjaman::with('detail')->findOrFail($request->id_peminjaman);

            // Hitung denda otomatis
            $tanggalHarusKembali = Carbon::parse($peminjaman->tanggal_pinjam)
                                            ->addDays($peminjaman->durasi_pinjam ?? 7);
            $tanggalKembali = Carbon::parse($request->tanggal_kembali);

            $hariTerlambat = 0;
            $denda = 0;

            if ($tanggalKembali->greaterThan($tanggalHarusKembali)) {
                $hariTerlambat = $tanggalKembali->diffInDays($tanggalHarusKembali);
                $denda = $hariTerlambat * Peminjaman::DENDA_PER_HARI;
            }

            // Simpan pengembalian
            Pengembalian::create([
                'id_peminjaman'   => $request->id_peminjaman,
                'tanggal_kembali' => $request->tanggal_kembali,
                'kondisi_kembali' => $request->kondisi_kembali ?? 'baik',
                'denda'           => $denda,
                'id_pegawai'      => $request->id_pegawai,
            ]);

            // Update status peminjaman jadi 'kembali'
            $peminjaman->update(['status_pinjam' => 'kembali']);

            // Kembalikan stok barang
            foreach ($peminjaman->detail as $detail) {
                $barang = Barang::find($detail->id_barang);
                if ($barang) {
                    $barang->increment('stok', $detail->jumlah);
                }
            }

            DB::commit();

            $msg = 'Pengembalian berhasil dicatat! Stok barang dikembalikan.';
            if ($denda > 0) {
                $msg .= ' Denda: Rp ' . number_format($denda, 0, ',', '.') . ' (' . $hariTerlambat . ' hari terlambat)';
            }

            return redirect()->route('pengembalian.index')->with('success', $msg);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $peminjaman = Peminjaman::with('pengguna')->get();
        $pegawai = Pegawai::all();
        return view('pengembalian.edit', compact('pengembalian', 'peminjaman', 'pegawai'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_peminjaman'   => 'required|exists:peminjaman,id_peminjaman',
            'tanggal_kembali' => 'required|date',
            'kondisi_kembali' => 'nullable|in:baik,rusak ringan,rusak berat',
            'denda'           => 'nullable|numeric|min:0',
            'id_pegawai'      => 'required|exists:pegawai,id_pegawai',
        ]);

        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->update($request->all());

        return redirect()->route('pengembalian.index')
                         ->with('success', 'Pengembalian berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $pengembalian = Pengembalian::with('peminjaman.detail')->findOrFail($id);

            // Kembalikan status peminjaman jadi 'dipinjam'
            if ($pengembalian->peminjaman) {
                $pengembalian->peminjaman->update(['status_pinjam' => 'dipinjam']);

                // Kurangi stok lagi (karena pengembalian dibatalkan)
                foreach ($pengembalian->peminjaman->detail as $detail) {
                    $barang = Barang::find($detail->id_barang);
                    if ($barang) {
                        $barang->decrement('stok', $detail->jumlah);
                    }
                }
            }

            $pengembalian->delete();
            DB::commit();

            return redirect()->route('pengembalian.index')
                             ->with('success', 'Pengembalian dihapus! Status peminjaman kembali ke dipinjam.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}