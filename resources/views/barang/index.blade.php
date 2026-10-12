@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 700; color: #1c1917;">
                <i class="fas fa-box" style="color: #06b6d4; margin-right: 8px;"></i>
                Daftar Barang
            </h1>
            <p style="font-size: 13px; color: #6b7280; margin-top: 4px;">Total: {{ $barang->count() }} barang</p>
        </div>
                @if(auth()->user()->role === 'admin')
            <a href="{{ route('barang.create') }}" class="btn btn-add">
                <i class="fas fa-plus"></i> Tambah Barang
            </a>
        @endif
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
                    <th>Nama Barang</th>
                    <th>Merk</th>
                    <th>Kategori</th>
                    <th>Ruangan</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barang as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td style="font-weight: 600;">{{ $item->nama_barang }}</td>
                        <td>{{ $item->merk ?? '-' }}</td>
                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                        <td>
                            @if (($item->stok ?? 0) > 5)
                                <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                                    {{ $item->stok ?? 0 }}
                                </span>
                            @elseif (($item->stok ?? 0) > 0)
                                <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                                    {{ $item->stok ?? 0 }}
                                </span>
                            @else
                                <span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                                    Habis
                                </span>
                            @endif
                        </td>
                        <td>
                                                        <div style="display: flex; gap: 6px; align-items: center;">
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('barang.edit', $item->id_barang) }}" class="btn btn-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('barang.destroy', $item->id_barang) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin hapus {{ $item->nama_barang }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span style="font-size: 11px; color: #9ca3af; font-style: italic;">Read only</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align: center; color: #9ca3af;">Belum ada data barang.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection