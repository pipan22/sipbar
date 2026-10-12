<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $judul }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1c1917; }
        .header { text-align: center; border-bottom: 3px solid #fbbf24; padding-bottom: 12px; margin-bottom: 18px; }
        .header h1 { color: #1c1917; font-size: 18px; margin: 0 0 4px; }
        .header p { color: #6b7280; font-size: 11px; margin: 0; }
        .info { margin-bottom: 14px; font-size: 11px; }
        .info strong { color: #1c1917; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th { background: #1c1917; color: #fbbf24; padding: 8px 6px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 6px; border-bottom: 1px solid #e5e7eb; font-size: 10px; vertical-align: top; }
        tr:nth-child(even) td { background: #f9fafb; }
        .badge { padding: 3px 8px; border-radius: 10px; font-size: 9px; font-weight: bold; }
        .badge-dipinjam { background: #fef3c7; color: #92400e; }
        .badge-kembali { background: #d1fae5; color: #065f46; }
        .badge-terlambat { background: #fee2e2; color: #991b1b; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; color: #6b7280; }
        .no-data { text-align: center; color: #9ca3af; padding: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SIPBAR — Sistem Peminjaman Barang</h1>
        <p>Universitas Lampung</p>
        <p style="margin-top: 6px; font-size: 14px; font-weight: bold; color: #1c1917;">{{ $judul }}</p>
    </div>

    <div class="info">
        <strong>Periode:</strong>
        {{ $dari ?? 'Semua' }} s/d {{ $sampai ?? 'Semua' }} |
        <strong>Status:</strong> {{ ucfirst($status) }} |
        <strong>Total:</strong> {{ $peminjaman->count() }} transaksi
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Peminjam</th>
                <th>Petugas</th>
                <th>Barang</th>
                <th>Tgl Pinjam</th>
                <th>Harus Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjaman as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->pengguna->nama ?? '-' }}</td>
                    <td>{{ $item->pegawai->nama_pegawai ?? '-' }}</td>
                    <td>
                        @foreach ($item->detail as $d)
                            {{ $d->barang->nama_barang ?? '-' }} ({{ $d->jumlah }}x)<br>
                        @endforeach
                    </td>
                    <td>{{ $item->tanggal_pinjam }}</td>
                    <td>{{ $item->tanggal_harus_kembali->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge badge-{{ $item->status_pinjam }}">
                            {{ strtoupper($item->status_pinjam) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="no-data">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ $tanggal_cetak }}
    </div>
</body>
</html>