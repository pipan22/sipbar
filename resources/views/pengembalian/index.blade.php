@extends('layouts.app')

@section('title', 'Daftar Pengembalian')

@section('content')
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 700; color: #1c1917;">
                <i class="fas fa-check-circle" style="color: #06b6d4; margin-right: 8px;"></i>
                Daftar Pengembalian
            </h1>
            <p style="font-size: 13px; color: #6b7280; margin-top: 4px;">Total: {{ $pengembalian->count() }} pengembalian</p>
        </div>
        <a href="{{ route('pengembalian.create') }}" class="btn btn-add">
            <i class="fas fa-plus"></i> Catat Pengembalian
        </a>
    </div>

    @if (session('success'))
        <div class="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Petugas</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Kondisi</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengembalian as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td style="font-weight: 600;">
                            {{ $item->peminjaman->pengguna->nama ?? '-' }}
                        </td>
                        <td>{{ $item->pegawai->nama_pegawai ?? '-' }}</td>
                        <td>{{ $item->peminjaman->tanggal_pinjam ?? '-' }}</td>
                        <td>{{ $item->tanggal_kembali }}</td>
                        <td>
                            @php
                                $kondisiMap = [
                                    'baik' => ['#d1fae5', '#065f46'],
                                    'rusak ringan' => ['#fef3c7', '#92400e'],
                                    'rusak berat' => ['#fee2e2', '#991b1b'],
                                ];
                                $c = $kondisiMap[$item->kondisi_kembali] ?? ['#f3f4f6', '#6b7280'];
                            @endphp
                            <span style="background: {{ $c[0] }}; color: {{ $c[1] }}; padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700;">
                                {{ $item->kondisi_kembali ?? '-' }}
                            </span>
                        </td>
                        <td>
                            @if ($item->denda > 0)
                                <span style="color: #dc2626; font-weight: 700;">
                                    Rp {{ number_format($item->denda, 0, ',', '.') }}
                                </span>
                            @else
                                <span style="color: #10b981; font-weight: 600;">
                                    Rp 0
                                </span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('pengembalian.edit', $item->id_pengembalian) }}" class="btn btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pengembalian.destroy', $item->id_pengembalian) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin hapus pengembalian ini? Stok barang akan dikurangi lagi.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" style="text-align: center; color: #9ca3af;">Belum ada data pengembalian.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection