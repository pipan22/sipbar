@extends('layouts.app')

@section('title', 'Daftar Pegawai')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 700; color: #1c1917;">
                <i class="fas fa-user-tie" style="color: #06b6d4; margin-right: 8px;"></i>
                Daftar Pegawai
            </h1>
            <p style="font-size: 13px; color: #6b7280; margin-top: 4px;">Total: {{ $pegawai->count() }} pegawai</p>
        </div>
        <a href="{{ route('pegawai.create') }}" class="btn btn-add">
            <i class="fas fa-plus"></i> Tambah Pegawai
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
                    <th>Nama Pegawai</th>
                    <th>Jabatan</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pegawai as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td style="font-weight: 600;">{{ $item->nama_pegawai }}</td>
                        <td>
                            @if ($item->jabatan)
                                <span style="background: #cffafe; color: #0e7490; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">{{ $item->jabatan }}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $item->no_hp ?? '-' }}</td>
                        <td style="font-size: 13px; color: #6b7280;">{{ Str::limit($item->alamat, 50) ?? '-' }}</td>
                        <td>
                            <div style="display: flex; gap: 6px; align-items: center;">
                                <a href="{{ route('pegawai.edit', $item->id_pegawai) }}" class="btn btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pegawai.destroy', $item->id_pegawai) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin hapus {{ $item->nama_pegawai }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align: center; color: #9ca3af;">Belum ada data pegawai.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection