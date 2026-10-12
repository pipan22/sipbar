@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
    @php
        $pendingCount = \App\Models\Peminjaman::where('status_pinjam', 'menunggu')->count();
    @endphp

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 700; color: #1c1917;">
                <i class="fas fa-clipboard-list" style="color: #fbbf24; margin-right: 8px;"></i>
                Daftar Peminjaman
            </h1>
            <p style="font-size: 13px; color: #6b7280; margin-top: 4px;">
                Total: {{ $peminjaman->count() }} transaksi
                @if($pendingCount > 0)
                    · <strong style="color: #dc2626;">{{ $pendingCount }} menunggu verifikasi</strong>
                @endif
            </p>
        </div>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('peminjaman.create') }}" class="btn btn-add">
                <i class="fas fa-plus"></i> Tambah Peminjaman
            </a>
        @endif
    </div>

    {{-- Filter Tab --}}
    <div style="display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap;">
        @php
            $tabs = [
                'semua' => ['Semua', '#1c1917', '#f3f4f6'],
                'menunggu' => ['Menunggu', '#3b82f6', '#dbeafe'],
                'dipinjam' => ['Dipinjam', '#f59e0b', '#fef3c7'],
                'terlambat' => ['Terlambat', '#dc2626', '#fee2e2'],
                'kembali' => ['Kembali', '#10b981', '#d1fae5'],
                'ditolak' => ['Ditolak', '#6b7280', '#f3f4f6'],
            ];
            $currentStatus = request('status', 'semua');
        @endphp
        @foreach($tabs as $key => $tab)
            <a href="{{ route('peminjaman.index', $key === 'semua' ? [] : ['status' => $key]) }}"
               style="padding: 8px 16px; border-radius: 20px; text-decoration: none; font-weight: 700; font-size: 13px; transition: all 0.2s;
                      {{ $currentStatus === $key
                          ? 'background: ' . $tab[1] . '; color: white;'
                          : 'background: ' . $tab[2] . '; color: ' . $tab[1] . ';' }}">
                {{ $tab[0] }}
                @if($key === 'menunggu' && $pendingCount > 0)
                    <span style="background: {{ $currentStatus === 'menunggu' ? 'rgba(255,255,255,0.3)' : '#dc2626' }}; color: white; padding: 1px 8px; border-radius: 10px; font-size: 10px; margin-left: 4px;">{{ $pendingCount }}</span>
                @endif
            </a>
        @endforeach
    </div>

    @if (session('success'))
        <div class="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #dc2626;">
            <strong><i class="fas fa-exclamation-circle"></i> Error:</strong>
            <ul style="margin: 8px 0 0 20px;">
                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Petugas</th>
                    <th>Barang</th>
                    <th>Tanggal Pinjam</th>
                    <th>Harus Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman as $item)
                    <tr style="{{ $item->status_pinjam === 'menunggu' ? 'background: #fef9e7;' : '' }}">
                        <td>{{ $loop->iteration }}</td>
                        <td style="font-weight: 600;">{{ $item->pengguna->nama ?? '-' }}</td>
                        <td>{{ $item->pegawai->nama_pegawai ?? '-' }}</td>
                        <td>
                            @foreach ($item->detail as $d)
                                <div style="font-size: 12px; color: #6b7280;">• {{ $d->barang->nama_barang ?? '-' }} ({{ $d->jumlah }}x)</div>
                            @endforeach
                        </td>
                        <td>{{ $item->tanggal_pinjam }}</td>
                        <td>{{ $item->tanggal_harus_kembali->format('d M Y') }}</td>
                        <td>
                            @php
                                $statusMap = [
                                    'menunggu'  => ['#dbeafe', '#1e40af', 'clock', 'Menunggu'],
                                    'dipinjam'  => ['#fef3c7', '#92400e', 'hand-holding', 'Dipinjam'],
                                    'kembali'   => ['#d1fae5', '#065f46', 'check-circle', 'Kembali'],
                                    'terlambat' => ['#fee2e2', '#991b1b', 'exclamation-triangle', 'Terlambat'],
                                    'ditolak'   => ['#f3f4f6', '#6b7280', 'times-circle', 'Ditolak'],
                                ];
                                $c = $statusMap[$item->status_pinjam] ?? ['#f3f4f6', '#6b7280', 'circle', $item->status_pinjam];
                            @endphp
                            <span style="background: {{ $c[0] }}; color: {{ $c[1] }}; padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="fas fa-{{ $c[2] }}"></i>
                                {{ $c[3] }}
                            </span>
                            @if ($item->hari_terlambat > 0)
                                <div style="font-size: 10px; color: #dc2626; font-weight: 700; margin-top: 4px;">
                                    +{{ $item->hari_terlambat }} hari (Rp {{ number_format($item->denda, 0, ',', '.') }})
                                </div>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px; align-items: center;">
                                @if($item->status_pinjam === 'menunggu')
                                    {{-- Tombol Setujui --}}
                                    <form action="{{ route('peminjaman.approve', $item->id_peminjaman) }}" method="POST" style="display: inline;" onsubmit="return confirm('Setujui peminjaman ini? Stok barang akan berkurang.')">
                                        @csrf
                                        <button type="submit" style="padding: 6px 14px; background: #10b981; color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 12px; cursor: pointer; font-family: inherit;">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                    </form>
                                    {{-- Tombol Tolak --}}
                                    <form action="{{ route('peminjaman.reject', $item->id_peminjaman) }}" method="POST" style="display: inline;" onsubmit="return confirm('Tolak peminjaman ini?')">
                                        @csrf
                                        <button type="submit" style="padding: 6px 14px; background: #ef4444; color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 12px; cursor: pointer; font-family: inherit;">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('peminjaman.show', $item->id_peminjaman) }}" class="btn btn-edit" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('peminjaman.edit', $item->id_peminjaman) }}" class="btn btn-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('peminjaman.destroy', $item->id_peminjaman) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin hapus? Stok barang akan dikembalikan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" style="text-align: center; color: #9ca3af; padding: 40px;">Belum ada data peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection