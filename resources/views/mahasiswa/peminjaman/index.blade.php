@extends('layouts.app')

@section('title', 'Peminjaman Saya')

@section('content')
    @php
        $pengguna = \App\Models\Pengguna::where('username', auth()->user()->username)->first();
        $totalMenunggu = $pengguna ? \App\Models\Peminjaman::where('id_pengguna', $pengguna->id_pengguna)->where('status_pinjam', 'menunggu')->count() : 0;
    @endphp

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 700; color: #1c1917;">
                <i class="fas fa-clipboard-list" style="color: #fbbf24; margin-right: 8px;"></i>
                Peminjaman Saya
            </h1>
            <p style="font-size: 13px; color: #6b7280; margin-top: 4px;">Total: {{ $peminjaman->count() }} peminjaman</p>
        </div>
        <a href="{{ route('mahasiswa.peminjaman.create') }}" class="btn btn-add">
            <i class="fas fa-plus"></i> Ajukan Peminjaman
        </a>
    </div>

    {{-- Filter Tab --}}
    <div style="display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap;">
        @php
            $tabs = [
                'semua'         => ['Semua', '#1c1917', '#f3f4f6'],
                'menunggu'      => ['Menunggu', '#3b82f6', '#dbeafe'],
                'disetujui'     => ['Disetujui', '#6366f1', '#e0e7ff'],
                'dipinjam'      => ['Dipinjam', '#f59e0b', '#fef3c7'],
                'terlambat'     => ['Terlambat', '#dc2626', '#fee2e2'],
                'dikembalikan'  => ['Dikembalikan', '#10b981', '#d1fae5'],
                'ditolak'       => ['Ditolak', '#6b7280', '#f3f4f6'],
            ];
            $currentStatus = request('status', 'semua');
        @endphp
        @foreach($tabs as $key => $tab)
            <a href="{{ route('mahasiswa.peminjaman.index', $key === 'semua' ? [] : ['status' => $key]) }}"
               style="padding: 8px 16px; border-radius: 20px; text-decoration: none; font-weight: 700; font-size: 13px;
                      {{ $currentStatus === $key
                          ? 'background: ' . $tab[1] . '; color: white;'
                          : 'background: ' . $tab[2] . '; color: ' . $tab[1] . ';' }}">
                {{ $tab[0] }}
                @if($key === 'menunggu' && $totalMenunggu > 0)
                    <span style="background: {{ $currentStatus === 'menunggu' ? 'rgba(255,255,255,0.3)' : '#dc2626' }}; color: white; padding: 1px 8px; border-radius: 10px; font-size: 10px; margin-left: 4px;">{{ $totalMenunggu }}</span>
                @endif
            </a>
        @endforeach
    </div>

    @if (session('success'))
        <div class="alert"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Barang</th>
                    <th>Petugas</th>
                    <th>Tanggal Pinjam</th>
                    <th>Harus Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman as $item)
                    <tr style="{{ $item->status_pinjam === 'menunggu' ? 'background: #fef9e7;' : ($item->status_pinjam === 'disetujui' ? 'background: #eef2ff;' : '') }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @foreach ($item->detail as $d)
                                <div style="font-size: 12px; color: #374151; font-weight: 600;">• {{ $d->barang->nama_barang ?? '-' }} ({{ $d->jumlah }}x)</div>
                            @endforeach
                        </td>
                        <td>
                            @if($item->pegawai)
                                {{ $item->pegawai->nama_pegawai }}
                            @else
                                <span style="color: #9ca3af; font-style: italic;">Belum ditentukan</span>
                            @endif
                        </td>
                        <td>{{ $item->tanggal_pinjam }}</td>
                        <td>{{ $item->tanggal_harus_kembali->format('d M Y') }}</td>
                        <td>
                            @php
                                $statusMap = [
                                    'menunggu'      => ['#dbeafe', '#1e40af', 'clock', 'Menunggu'],
                                    'disetujui'     => ['#e0e7ff', '#3730a3', 'thumbs-up', 'Disetujui'],
                                    'dipinjam'      => ['#fef3c7', '#92400e', 'hand-holding', 'Dipinjam'],
                                    'dikembalikan'  => ['#d1fae5', '#065f46', 'check-circle', 'Dikembalikan'],
                                    'terlambat'     => ['#fee2e2', '#991b1b', 'exclamation-triangle', 'Terlambat'],
                                    'ditolak'       => ['#f3f4f6', '#6b7280', 'times-circle', 'Ditolak'],
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
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('mahasiswa.peminjaman.show', $item->id_peminjaman) }}" style="padding: 6px 12px; background: #3b82f6; color: white; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600;">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                @if($item->status_pinjam === 'menunggu')
                                    <form action="{{ route('mahasiswa.peminjaman.batal', $item->id_peminjaman) }}" method="POST" style="display: inline;" onsubmit="return confirm('Batalkan pengajuan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="padding: 6px 12px; background: #ef4444; color: white; border: none; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; font-family: inherit;">
                                            <i class="fas fa-times"></i> Batalkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align: center; color: #9ca3af; padding: 40px;">
                        Belum ada peminjaman. <a href="{{ route('mahasiswa.katalog') }}" style="color: #d97706; font-weight: 700;">Lihat katalog →</a>
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection