@extends('layouts.app')

@section('title', 'Edit Ruangan')

@section('content')
    <div style="max-width: 700px;">
        <h1 style="font-size: 24px; font-weight: 700; color: #1c1917; margin-bottom: 24px;">
            <i class="fas fa-edit" style="color: #fbbf24; margin-right: 8px;"></i>
            Edit Ruangan
        </h1>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #dc2626;">
                <strong>Ada kesalahan:</strong>
                <ul style="margin: 8px 0 0 20px;">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ruangan.update', $ruangan->id_ruangan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card" style="padding: 28px;">
                <div style="margin-bottom: 18px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Nama Ruangan <span style="color: #dc2626;">*</span></label>
                    <input type="text" name="nama_ruangan" value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}" required
                           style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                </div>

                <div style="margin-bottom: 18px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Lantai</label>
                    <input type="number" name="lantai" value="{{ old('lantai', $ruangan->lantai) }}"
                           style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                </div>

                <div style="margin-bottom: 18px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Pegawai Penanggung Jawab</label>
                    <select name="id_pegawai"
                            style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                        <option value="">-- Pilih Pegawai --</option>
                        @foreach ($pegawai as $p)
                            <option value="{{ $p->id_pegawai }}" {{ old('id_pegawai', $ruangan->id_pegawai) == $p->id_pegawai ? 'selected' : '' }}>
                                {{ $p->nama_pegawai }} - {{ $p->jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Keterangan</label>
                    <textarea name="keterangan" rows="4"
                              style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">{{ old('keterangan', $ruangan->keterangan) }}</textarea>
                </div>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 20px;">
                <button type="submit" style="padding: 12px 28px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; border-radius: 10px; color: white; font-weight: 700; cursor: pointer; font-family: inherit; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('ruangan.index') }}" style="padding: 12px 28px; background: #f3f4f6; border-radius: 10px; color: #374151; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
@endsection