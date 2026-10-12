<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $judul }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1c1917; }
        .header { text-align: center; border-bottom: 3px solid #3b82f6; padding-bottom: 12px; margin-bottom: 18px; }
        .header h1 { color: #1c1917; font-size: 18px; margin: 0 0 4px; }
        .header p { color: #6b7280; font-size: 11px; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th { background: #1c1917; color: #fbbf24; padding: 8px 6px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 6px; border-bottom: 1px solid #e5e7eb; font-size: 10px; }
        tr:nth-child(even) td { background: #f9fafb; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SIPBAR — Sistem Peminjaman Barang</h1>
        <p>Universitas Lampung</p>
        <p style="margin-top: 6px; font-size: 14px; font-weight: bold; color: #1c1917;">{{ $judul }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Nama Barang</th>
                <th>Merk</th>
                <th>Kategori</th>
                <th>Ruangan</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($barang as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->merk ?? '-' }}</td>
                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                    <td>{{ $item->stok }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ $tanggal_cetak }}
    </div>
</body>
</html>