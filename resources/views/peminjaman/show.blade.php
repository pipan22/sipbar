@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
    <div style="max-width: 800px;">
        <!-- Tombol Kembali di Atas -->
        <a href="{{ route('peminjaman.index') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; background: #f3f4f6; border-radius: 10px; color: #374151; font-weight: 700; text-decoration: none; font-size: 14px; margin-bottom: 20px;">
            <i class="fas fa-arrow-left"></i>
        </a>

        <h1 style="font-size: 24px; font-weight: 700; color: #1c1917; margin-bottom: 24px;">
            <i class="fas fa-file-alt" style="color: #06b6d4; margin-right: 8px;"></i>
            Detail Peminjaman #{{ $peminjaman->id_peminjaman }}
        </h1>

        <!-- Tombol Aksi (Setujui/Tolak kalau menunggu) -->
        @if($peminjaman->status_pinjam === 'menunggu')
            <div style="background: #dbeafe; border-radius: 12px; padding: 16px 20px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; border-left: 4px solid #3b82f6;">
                <div>
                    <div style="font-size: 14px; font-weight: 700; color: #1e40af;">
                        <i class="fas fa-clock"></i> Peminjaman ini menunggu verifikasi
                    </div>
                    <div style="font-size: 12px; color: #1e40af; opacity: 0.8; margin-top: 2px;">Setujui atau tolak pengajuan ini.</div>
                </div>
                <div style="display: flex; gap: 8px;">
                    <form action="{{ route('peminjaman.approve', $peminjaman->id_peminjaman) }}" method="POST" style="display: inline;" onsubmit="return confirm('Setujui peminjaman ini? Stok barang akan berkurang.')">
                        @csrf
                        <button type="submit" style="padding: 10px 20px; background: #10b981; color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; font-family: inherit;">
                            <i class="fas fa-check"></i> Setujui
                        </button>
                    </form>
                    <form action="{{ route('peminjaman.reject', $peminjaman->id_peminjaman) }}" method="POST" style="display: inline;" onsubmit="return confirm('Tolak peminjaman ini?')">
                        @csrf
                        <button type="submit" style="padding: 10px 20px; background: #ef4444; color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; font-family: inherit;">
                            <i class="fas fa-times"></i> Tolak
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <!-- Info Peminjaman -->
        <div class="card" style="padding: 24px; margin-bottom: 20px;">
            <h3 style="font-size: 15px; font-weight: 700; color: #1c1917; margin-bottom: 16px;">
                <i class="fas fa-info-circle" style="color: #06b6d4; margin-right: 6px;"></i>
                Info Peminjaman
            </h3>
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 10px 0; color: #6b7280; font-size: 13px; width: 180px;">Peminjam</td>
                    <td style="padding: 10px 0; font-weight: 600; color: #1c1917;">{{ $peminjaman->pengguna->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #6b7280; font-size: 13px;">Petugas</td>
                    <td style="padding: 10px 0; font-weight: 600; color: #1c1917;">{{ $peminjaman->pegawai->nama_pegawai ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #6b7280; font-size: 13px;">Tanggal Pinjam</td>
                    <td style="padding: 10px 0; font-weight: 600; color: #1c1917;">{{ $peminjaman->tanggal_pinjam }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #6b7280; font-size: 13px;">Durasi</td>
                    <td style="padding: 10px 0; font-weight: 600; color: #1c1917;">{{ $peminjaman->durasi_pinjam }} hari</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #6b7280; font-size: 13px;">Harus Kembali</td>
                    <td style="padding: 10px 0; font-weight: 600; color: #1c1917;">{{ $peminjaman->tanggal_harus_kembali->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #6b7280; font-size: 13px;">Status</td>
                    <td style="padding: 10px 0;">
                        @php
                            $statusMap = [
                                'menunggu' => ['#dbeafe', '#1e40af'],
                                'dipinjam' => ['#fef3c7', '#92400e'],
                                'kembali' => ['#d1fae5', '#065f46'],
                                'terlambat' => ['#fee2e2', '#991b1b'],
                                'ditolak' => ['#f3f4f6', '#6b7280'],
                            ];
                            $c = $statusMap[$peminjaman->status_pinjam] ?? ['#f3f4f6', '#6b7280'];
                        @endphp
                        <span style="background: {{ $c[0] }}; color: {{ $c[1] }}; padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block;">
                            {{ ucfirst($peminjaman->status_pinjam) }}
                        </span>
                    </td>
                </tr>
                if ($peminjaman->hari_terlambat > 0 && $peminjaman->status_pinjam === 'terlambat')
                    <tr>
                        <td style="padding: 10px 0; color: #6b7280; font-size: 13px;">Keterlambatan</td>
                        <td style="padding: 10px 0; color: #dc2626; font-weight: 700;">
                            {{ $peminjaman->hari_terlambat }} hari — Denda: Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                        </td>
                    </tr>
                @endif
            </table>
        </div>

        <!-- Barang Dipinjam -->
        <div class="card" style="padding: 24px;">
            <h3 style="font-size: 15px; font-weight: 700; color: #1c1917; margin-bottom: 16px;">
                <i class="fas fa-box" style="color: #06b6d4; margin-right: 6px;"></i>
                Barang yang Dipinjam
            </h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peminjaman->detail as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $d->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $d->jumlah }}</td>
                            <td>{{ $d->kondisi_pinjam ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection