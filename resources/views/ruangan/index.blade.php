@extends('layouts.app')

@section('title', 'Daftar Ruangan')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 700; color: #1c1917;">
                <i class="fas fa-building" style="color: #06b6d4; margin-right: 8px;"></i>
                Daftar Ruangan
            </h1>
            <p style="font-size: 13px; color: #6b7280; margin-top: 4px;">Total: {{ $ruangan->count() }} ruangan</p>
        </div>
                @if(auth()->user()->role === 'admin')
            <a href="{{ route('ruangan.create') }}" class="btn btn-add">
                <i class="fas fa-plus"></i> Tambah Ruangan
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
                    <th>Nama Ruangan</th>
                    <th>Lantai</th>
                    <th>Pegawai Penanggung Jawab</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ruangan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td style="font-weight: 600;">{{ $item->nama_ruangan }}</td>
                        <td>
                            <span style="background: #cffafe; color: #0e7490; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">
    Lantai {{ $item->lantai ?? '-' }}
</span>
                        </td>
                        <td>{{ $item->pegawai->nama_pegawai ?? '-' }}</td>
                        <td style="font-size: 13px; color: #6b7280;">{{ Str::limit($item->keterangan, 50) ?? '-' }}</td>
                                                <td>
                            <div style="display: flex; gap: 6px; align-items: center;">
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('ruangan.edit', $item->id_ruangan) }}" class="btn btn-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('ruangan.destroy', $item->id_ruangan) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin hapus {{ $item->nama_ruangan }}?')">
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
                    <tr><td colspan="6" style="text-align: center; color: #9ca3af;">Belum ada data ruangan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection