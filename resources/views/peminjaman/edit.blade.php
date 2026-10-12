@extends('layouts.app')

@section('title', 'Edit Peminjaman')

@section('content')
    <div style="max-width: 700px;">
        <h1 style="font-size: 24px; font-weight: 700; color: #1c1917; margin-bottom: 24px;">
            <i class="fas fa-edit" style="color: #fbbf24; margin-right: 8px;"></i>
            Edit Peminjaman #{{ $peminjaman->id_peminjaman }}
        </h1>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #dc2626;">
                <strong>Ada kesalahan:</strong>
                <ul style="margin: 8px 0 0 20px;">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('peminjaman.update', $peminjaman->id_peminjaman) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card" style="padding: 28px;">
                <div style="margin-bottom: 18px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Peminjam</label>
                    <select name="id_pengguna" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                        @foreach ($pengguna as $p)
                            <option value="{{ $p->id_pengguna }}" {{ old('id_pengguna', $peminjaman->id_pengguna) == $p->id_pengguna ? 'selected' : '' }}>{{ $p->nama }} ({{ $p->username }})</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 18px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Petugas</label>
                    <select name="id_pegawai" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                        @foreach ($pegawai as $p)
                            <option value="{{ $p->id_pegawai }}" {{ old('id_pegawai', $peminjaman->id_pegawai) == $p->id_pegawai ? 'selected' : '' }}>{{ $p->nama_pegawai }} - {{ $p->jabatan }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                    <div>
                        <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Durasi (hari)</label>
                        <input type="number" name="durasi_pinjam" value="{{ old('durasi_pinjam', $peminjaman->durasi_pinjam) }}" min="1" style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                    </div>
                </div>

                <div>
    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Status</label>
    <select name="status_pinjam" style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
        @foreach ([
            'menunggu' => 'Menunggu',
            'disetujui' => 'Disetujui',
            'dipinjam' => 'Dipinjam',
            'dikembalikan' => 'Dikembalikan',
            'terlambat' => 'Terlambat',
            'ditolak' => 'Ditolak',
        ] as $val => $label)
            <option value="{{ $val }}" {{ old('status_pinjam', $peminjaman->status_pinjam) == $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
</div>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 20px;">
                <button type="submit" style="padding: 12px 28px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; border-radius: 10px; color: white; font-weight: 700; cursor: pointer; font-family: inherit; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('peminjaman.index') }}" style="padding: 12px 28px; background: #f3f4f6; border-radius: 10px; color: #374151; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
@endsection