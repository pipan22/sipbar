<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $judul }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1c1917; }
        .header { text-align: center; border-bottom: 3px solid #10b981; padding-bottom: 12px; margin-bottom: 18px; }
        .header h1 { color: #1c1917; font-size: 18px; margin: 0 0 4px; }
        .header p { color: #6b7280; font-size: 11px; margin: 0; }
        .info { margin-bottom: 14px; font-size: 11px; }
        .total-denda { background: #fee2e2; color: #991b1b; padding: 8px 14px; border-radius: 8px; font-weight: bold; display: inline-block; margin-top: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th { background: #1c1917; color: #fbbf24; padding: 8px 6px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 6px; border-bottom: 1px solid #e5e7eb; font-size: 10px; }
        tr:nth-child(even) td { background: #f9fafb; }
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
        <strong>Periode:</strong> {{ $dari ?? 'Semua' }} s/d {{ $sampai ?? 'Semua' }} |
        <strong>Total:</strong> {{ $pengembalian->count() }} pengembalian
        <div class="total-denda">Total Denda: Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Peminjam</th>
                <th>Petugas</th>
                <th>Tgl Kembali</th>
                <th>Kondisi</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengembalian as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->peminjaman->pengguna->nama ?? '-' }}</td>
                    <td>{{ $item->pegawai->nama_pegawai ?? '-' }}</td>
                    <td>{{ $item->tanggal_kembali }}</td>
                    <td>{{ $item->kondisi_kembali ?? '-' }}</td>
                    <td>{{ $item->denda > 0 ? 'Rp ' . number_format($item->denda, 0, ',', '.') : 'Rp 0' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="no-data">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ $tanggal_cetak }}
    </div>
</body>
</html>