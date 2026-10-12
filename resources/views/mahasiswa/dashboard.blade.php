@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    @php
        $pengguna = \App\Models\Pengguna::where('username', auth()->user()->username)->first();
        
        $disetujui = $pengguna ? \App\Models\Peminjaman::where('id_pengguna', $pengguna->id_pengguna)
                                ->where('status_pinjam', 'disetujui')->count() : 0;
        
        $terlambat = $pengguna ? \App\Models\Peminjaman::where('id_pengguna', $pengguna->id_pengguna)
                                ->where('status_pinjam', 'terlambat')->count() : 0;
    @endphp

    @if($disetujui > 0)
        <div style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 16px; padding: 20px 24px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; border-left: 4px solid #6366f1; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15); flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: white; display: flex; align-items: center; justify-content: center; color: #4338ca; font-size: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <i class="fas fa-hand-holding"></i>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #3730a3; margin-bottom: 2px;">
                        {{ $disetujui }} peminjaman Anda telah disetujui
                    </h3>
                    <p style="font-size: 13px; color: #4338ca;">Silakan ambil barang di petugas yang tertera.</p>
                </div>
            </div>
            <a href="{{ route('mahasiswa.peminjaman.index', ['status' => 'disetujui']) }}" style="padding: 10px 20px; background: #6366f1; color: white; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 13px;">
                <i class="fas fa-eye"></i> Lihat Detail
            </a>
        </div>
    @endif

    @if($terlambat > 0)
        <div style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-radius: 16px; padding: 20px 24px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; border-left: 4px solid #dc2626; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15); flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: white; display: flex; align-items: center; justify-content: center; color: #dc2626; font-size: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #991b1b; margin-bottom: 2px;">
                        {{ $terlambat }} peminjaman Anda TERLAMBAT
                    </h3>
                    <p style="font-size: 13px; color: #b91c1c;">Segera kembalikan barang ke petugas untuk menghindari denda.</p>
                </div>
            </div>
            <a href="{{ route('mahasiswa.peminjaman.index', ['status' => 'terlambat']) }}" style="padding: 10px 20px; background: #dc2626; color: white; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 13px;">
                <i class="fas fa-eye"></i> Lihat Detail
            </a>
        </div>
    @endif
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 24px; font-weight: 700; color: #1c1917;">
            <i class="fas fa-home" style="color: #fbbf24; margin-right: 8px;"></i>
            Halo, {{ Auth::user()->name }}!
        </h1>
        <p style="font-size: 13px; color: #6b7280; margin-top: 4px;">Selamat datang di SIPBAR — Sistem Peminjaman Barang</p>
    </div>

    <!-- Statistik -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 28px;">
        <div class="card" style="border-left: 4px solid #fbbf24; padding: 20px;">
            <div style="font-size: 11px; color: #6b7280; text-transform: uppercase; font-weight: 600;">Total Peminjaman</div>
            <div style="font-size: 32px; font-weight: 800; color: #1c1917; margin-top: 6px;">{{ $totalPeminjaman }}</div>
            <div style="font-size: 12px; color: #9ca3af; margin-top: 4px;">Semua transaksi</div>
        </div>
        <div class="card" style="border-left: 4px solid #f59e0b; padding: 20px;">
            <div style="font-size: 11px; color: #6b7280; text-transform: uppercase; font-weight: 600;">Sedang Dipinjam</div>
            <div style="font-size: 32px; font-weight: 800; color: #1c1917; margin-top: 6px;">{{ $aktif }}</div>
            <div style="font-size: 12px; color: #9ca3af; margin-top: 4px;">Belum dikembalikan</div>
        </div>
        <div class="card" style="border-left: 4px solid #ef4444; padding: 20px;">
            <div style="font-size: 11px; color: #6b7280; text-transform: uppercase; font-weight: 600;">Terlambat</div>
            <div style="font-size: 32px; font-weight: 800; color: #dc2626; margin-top: 6px;">{{ $terlambat }}</div>
            <div style="font-size: 12px; color: #9ca3af; margin-top: 4px;">Perlu segera dikembalikan</div>
        </div>
        <div class="card" style="border-left: 4px solid #10b981; padding: 20px;">
            <div style="font-size: 11px; color: #6b7280; text-transform: uppercase; font-weight: 600;">Sudah Kembali</div>
            <div style="font-size: 32px; font-weight: 800; color: #1c1917; margin-top: 6px;">{{ $dikembalikan }}</div>
            <div style="font-size: 12px; color: #9ca3af; margin-top: 4px;">Selesai</div>
        </div>
    </div>

    <!-- CTA -->
    <div style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); border-radius: 16px; padding: 28px; margin-bottom: 28px; box-shadow: 0 8px 24px rgba(251, 191, 36, 0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap;">
            <div style="color: white;">
                <h2 style="font-size: 20px; font-weight: 800; margin-bottom: 6px;">Mau pinjam barang?</h2>
                <p style="font-size: 14px; opacity: 0.9;">Lihat katalog barang dan ajukan peminjaman sekarang.</p>
            </div>
            <a href="{{ route('mahasiswa.katalog') }}" style="padding: 12px 24px; background: white; color: #d97706; border-radius: 10px; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-search"></i> Lihat Katalog
            </a>
        </div>
    </div>

    <!-- Peminjaman Terbaru -->
    <div class="card" style="padding: 0; overflow: hidden;">
        <div style="padding: 20px 24px; border-bottom: 1px solid #f0f2f5;">
            <h3 style="font-size: 16px; font-weight: 700; color: #1c1917;">
                <i class="fas fa-history" style="color: #fbbf24; margin-right: 8px;"></i>
                Peminjaman Terbaru
            </h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamanTerbaru as $p)
                    <tr>
                        <td>
                            @foreach ($p->detail as $d)
                                <div style="font-size: 13px; font-weight: 600;">• {{ $d->barang->nama_barang ?? '-' }} ({{ $d->jumlah }}x)</div>
                            @endforeach
                        </td>
                        <td>{{ $p->tanggal_pinjam }}</td>
                        <td>
                            @php
                                $colors = [
                                    'dipinjam' => ['#fef3c7', '#92400e'],
                                    'kembali' => ['#d1fae5', '#065f46'],
                                    'terlambat' => ['#fee2e2', '#991b1b'],
                                ];
                                $c = $colors[$p->status_pinjam] ?? ['#f3f4f6', '#6b7280'];
                            @endphp
                            <span style="background: {{ $c[0] }}; color: {{ $c[1] }}; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                                {{ $p->status_pinjam }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" style="text-align: center; color: #9ca3af; padding: 30px;">
                        Belum ada peminjaman. <a href="{{ route('mahasiswa.katalog') }}" style="color: #d97706; font-weight: 700;">Mulai pinjam sekarang →</a>
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection