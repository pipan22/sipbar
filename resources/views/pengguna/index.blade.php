@extends('layouts.app')

@section('title', 'Daftar Pengguna')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 700; color: #1c1917;">
                <i class="fas fa-users" style="color: #06b6d4; margin-right: 8px;"></i>
                Daftar Pengguna
            </h1>
            <p style="font-size: 13px; color: #6b7280; margin-top: 4px;">Total: {{ $pengguna->count() }} pengguna</p>
        </div>
        <a href="{{ route('pengguna.create') }}" class="btn btn-add">
            <i class="fas fa-plus"></i> Tambah Pengguna
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
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengguna as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td style="font-weight: 600;">{{ $item->nama }}</td>
                        <td>
                            <span style="background: #e0e7ff; color: #3730a3; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                                {{ $item->username }}
                            </span>
                        </td>
                        <td style="font-size: 13px; color: #6b7280;">{{ $item->email }}</td>
                        <td>
                            <div style="display: flex; gap: 6px; align-items: center;">
                                <a href="{{ route('pengguna.edit', $item->id_pengguna) }}" class="btn btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pengguna.destroy', $item->id_pengguna) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin hapus {{ $item->nama }}?')">
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
                    <tr><td colspan="5" style="text-align: center; color: #9ca3af;">Belum ada data pengguna.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection