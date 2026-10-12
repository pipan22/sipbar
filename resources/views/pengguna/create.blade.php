@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <div style="max-width: 700px;">
        <h1 style="font-size: 24px; font-weight: 700; color: #1c1917; margin-bottom: 24px;">
            <i class="fas fa-user-plus" style="color: #fbbf24; margin-right: 8px;"></i>
            Tambah Pengguna
        </h1>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #dc2626;">
                <strong><i class="fas fa-exclamation-circle"></i> Ada kesalahan:</strong>
                <ul style="margin: 8px 0 0 20px;">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pengguna.store') }}" method="POST">
            @csrf

            <div class="card" style="padding: 28px;">
                <div style="margin-bottom: 18px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Nama Lengkap <span style="color: #dc2626;">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required
                           style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                    <div>
                        <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Username <span style="color: #dc2626;">*</span></label>
                        <input type="text" name="username" value="{{ old('username') }}" required
                               style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Email <span style="color: #dc2626;">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                    </div>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Password <span style="color: #dc2626;">*</span></label>
                    <input type="password" name="password" required
                           style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                    <p style="font-size: 12px; color: #6b7280; margin-top: 4px;">Minimal 6 karakter.</p>
                </div>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 20px;">
                <button type="submit" style="padding: 12px 28px; background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); border: none; border-radius: 10px; color: white; font-weight: 700; cursor: pointer; font-family: inherit; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(251, 191, 36, 0.4);">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('pengguna.index') }}" style="padding: 12px 28px; background: #f3f4f6; border-radius: 10px; color: #374151; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
@endsection