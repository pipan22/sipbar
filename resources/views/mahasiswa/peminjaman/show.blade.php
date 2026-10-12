@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
    <div style="max-width: 800px;">
        <!-- Tombol Kembali di Atas -->
        <a href="{{ route('mahasiswa.peminjaman.index') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; background: #f3f4f6; border-radius: 10px; color: #374151; font-weight: 700; text-decoration: none; font-size: 14px; margin-bottom: 20px;">
            <i class="fas fa-arrow-left"></i> 
        </a>

        <h1 style="font-size: 24px; font-weight: 700; color: #1c1917; margin-bottom: 24px;">
            <i class="fas fa-file-alt" style="color: #fbbf24; margin-right: 8px;"></i>
            Detail Peminjaman #{{ $peminjaman->id_peminjaman }}
        </h1>

        <!-- Info Peminjaman -->
        <div class="card" style="padding: 24px; margin-bottom: 20px;">
            <h3 style="font-size: 15px; font-weight: 700; color: #1c1917; margin-bottom: 16px;">
                <i class="fas fa-info-circle" style="color: #fbbf24; margin-right: 6px;"></i>
                Info Peminjaman
            </h3>
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 10px 0; color: #6b7280; font-size: 13px; width: 180px;">Petugas</td>
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
                            $colors = [
                                'dipinjam' => ['#fef3c7', '#92400e'],
                                'kembali' => ['#d1fae5', '#065f46'],
                                'terlambat' => ['#fee2e2', '#991b1b'],
                            ];
                            $c = $colors[$peminjaman->status_pinjam] ?? ['#f3f4f6', '#6b7280'];
                        @endphp
                        <span style="background: {{ $c[0] }}; color: {{ $c[1] }}; padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block;">
                            {{ $peminjaman->status_pinjam }}
                        </span>
                    </td>
                </tr>
                @if ($peminjaman->hari_terlambat > 0)
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
                <i class="fas fa-box" style="color: #fbbf24; margin-right: 6px;"></i>
                Barang Dipinjam
            </h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
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