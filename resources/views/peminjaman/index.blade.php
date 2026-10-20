@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
    @php
        $pendingCount = \App\Models\Peminjaman::where('status_pinjam', 'menunggu')->count();
        $disetujuiCount = \App\Models\Peminjaman::where('status_pinjam', 'disetujui')->count();
    @endphp

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 700; color: #1c1917;">
                <i class="fas fa-clipboard-list" style="color: #06b6d4; margin-right: 8px;"></i>
                Daftar Peminjaman
            </h1>
            <p style="font-size: 13px; color: #6b7280; margin-top: 4px;">
                Total: {{ $peminjaman->count() }} transaksi
                @if($pendingCount > 0)
                    · <strong style="color: #dc2626;">{{ $pendingCount }} menunggu</strong>
                @endif
                @if($disetujuiCount > 0)
                    · <strong style="color: #6366f1;">{{ $disetujuiCount }} siap serah terima</strong>
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
            <a href="{{ route('peminjaman.index', $key === 'semua' ? [] : ['status' => $key]) }}"
               style="padding: 8px 16px; border-radius: 20px; text-decoration: none; font-weight: 700; font-size: 13px;
                      {{ $currentStatus === $key
                          ? 'background: ' . $tab[1] . '; color: white;'
                          : 'background: ' . $tab[2] . '; color: ' . $tab[1] . ';' }}">
                {{ $tab[0] }}
            </a>
        @endforeach
    </div>

    @if (session('success'))
        <div class="alert"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #dc2626;">
            <strong>Error:</strong>
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
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman as $item)
                    <tr style="{{ $item->status_pinjam === 'menunggu' ? 'background: #fef9e7;' : ($item->status_pinjam === 'disetujui' ? 'background: #eef2ff;' : '') }}">
                        <td>{{ $loop->iteration }}</td>
                        <td style="font-weight: 600;">{{ $item->pengguna->nama ?? '-' }}</td>
                        <td>
                            @if($item->pegawai)
                                {{ $item->pegawai->nama_pegawai }}
                            @else
                                <span style="color: #9ca3af; font-style: italic;">Belum ditentukan</span>
                            @endif
                        </td>
                        <td>
                            @foreach ($item->detail as $d)
                                <div style="font-size: 12px; color: #6b7280;">• {{ $d->barang->nama_barang ?? '-' }} ({{ $d->jumlah }}x)</div>
                            @endforeach
                        </td>
                        <td>{{ $item->tanggal_pinjam }}</td>
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
                            @if ($item->hari_terlambat > 0 && $item->status_pinjam === 'terlambat')
                                <div style="font-size: 10px; color: #dc2626; font-weight: 700; margin-top: 4px;">
                                +{{ $item->hari_terlambat }} hari (Rp {{ number_format($item->denda, 0, ',', '.') }})
                                </div>
                            @endif
                        </td>
                        <td>
                            {{-- ADMIN: Baris Menunggu → dropdown + Setujui + Tolak --}}
                            @if($item->status_pinjam === 'menunggu' && auth()->user()->role === 'admin')
                                <div style="display: flex; gap: 6px; align-items: center;">
                                    <form action="{{ route('peminjaman.approve', $item->id_peminjaman) }}" method="POST" style="display: flex; gap: 4px; align-items: center;">
                                        @csrf
                                        <select name="id_pegawai" required style="padding: 6px 10px; border: 1.5px solid #e5e7eb; border-radius: 6px; font-size: 12px; font-family: inherit; background: white; width: 150px;">
                                            <option value="">Pilih Petugas</option>
                                            @foreach(\App\Models\Pegawai::all() as $p)
                                                <option value="{{ $p->id_pegawai }}">{{ $p->nama_pegawai }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" style="padding: 6px 14px; background: #10b981; color: white; border: none; border-radius: 6px; font-weight: 700; font-size: 12px; cursor: pointer; font-family: inherit; white-space: nowrap;" onclick="return confirm('Setujui peminjaman ini?')">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                    </form>
                                    <form action="{{ route('peminjaman.reject', $item->id_peminjaman) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" style="padding: 6px 14px; background: #ef4444; color: white; border: none; border-radius: 6px; font-weight: 700; font-size: 12px; cursor: pointer; font-family: inherit; white-space: nowrap;" onclick="return confirm('Tolak peminjaman ini?')">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </form>
                                </div>

                            {{-- PEGAWAI: Baris Disetujui → tombol Serah Terima --}}
                            @elseif($item->status_pinjam === 'disetujui' && auth()->user()->role === 'pegawai')
                                <div style="display: flex; gap: 6px;">
                                    <form action="{{ route('peminjaman.serah', $item->id_peminjaman) }}" method="POST" onsubmit="return confirm('Serahkan barang ke mahasiswa?')">
                                        @csrf
                                        <button type="submit" style="padding: 6px 14px; background: #f59e0b; color: white; border: none; border-radius: 6px; font-weight: 700; font-size: 12px; cursor: pointer; font-family: inherit; white-space: nowrap;">
                                            <i class="fas fa-hand-holding"></i> Serah Terima
                                        </button>
                                    </form>
                                    <a href="{{ route('peminjaman.show', $item->id_peminjaman) }}" class="btn btn-edit" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>

                            {{-- PEGAWAI: Baris Dipinjam/Terlambat → tombol Terima Kembali --}}
                            @elseif(in_array($item->status_pinjam, ['dipinjam', 'terlambat']) && auth()->user()->role === 'pegawai')
                                <div style="display: flex; gap: 6px;">
                                    <form action="{{ route('peminjaman.terima', $item->id_peminjaman) }}" method="POST" onsubmit="return confirm('Terima pengembalian? Stok akan bertambah.')">
                                        @csrf
                                        <button type="submit" style="padding: 6px 14px; background: #10b981; color: white; border: none; border-radius: 6px; font-weight: 700; font-size: 12px; cursor: pointer; font-family: inherit; white-space: nowrap;">
                                            <i class="fas fa-check-double"></i> Terima Kembali
                                        </button>
                                    </form>
                                    <a href="{{ route('peminjaman.show', $item->id_peminjaman) }}" class="btn btn-edit" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>

                            {{-- ADMIN/LAINNYA: Baris biasa → Detail + Edit + Hapus --}}
                            @else
                                <div style="display: flex; gap: 6px;">
                                    <a href="{{ route('peminjaman.show', $item->id_peminjaman) }}" class="btn btn-edit" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(auth()->user()->role === 'admin' && !in_array($item->status_pinjam, ['dikembalikan', 'ditolak']))
                                        <a href="{{ route('peminjaman.edit', $item->id_peminjaman) }}" class="btn btn-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('peminjaman.destroy', $item->id_peminjaman) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align: center; color: #9ca3af; padding: 40px;">Belum ada data peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection