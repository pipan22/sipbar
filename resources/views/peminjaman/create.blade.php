@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')
    <div style="max-width: 900px;">
        <h1 style="font-size: 24px; font-weight: 700; color: #1c1917; margin-bottom: 24px;">
            <i class="fas fa-clipboard-list" style="color: #fbbf24; margin-right: 8px;"></i>
            Tambah Peminjaman
        </h1>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #dc2626;">
                <strong><i class="fas fa-exclamation-circle"></i> Ada kesalahan:</strong>
                <ul style="margin: 8px 0 0 20px;">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('peminjaman.store') }}" method="POST" id="formPeminjaman">
            @csrf

            <!-- Data Peminjam -->
            <div class="card" style="padding: 24px; margin-bottom: 20px;">
                <h3 style="font-size: 16px; font-weight: 700; color: #1c1917; margin-bottom: 18px;">
                    <i class="fas fa-user" style="color: #fbbf24; margin-right: 6px;"></i>
                    Data Peminjam
                </h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Peminjam</label>
                        <select name="id_pengguna" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                            <option value="">-- Pilih Pengguna --</option>
                            @foreach ($pengguna as $p)
                                <option value="{{ $p->id_pengguna }}" {{ old('id_pengguna') == $p->id_pengguna ? 'selected' : '' }}>
                                    {{ $p->nama }} ({{ $p->username }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Petugas</label>
                        <select name="id_pegawai" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach ($pegawai as $p)
                                <option value="{{ $p->id_pegawai }}" {{ old('id_pegawai') == $p->id_pegawai ? 'selected' : '' }}>
                                    {{ $p->nama_pegawai }} - {{ $p->jabatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Durasi Pinjam (hari)</label>
                        <input type="number" name="durasi_pinjam" value="{{ old('durasi_pinjam', 7) }}" min="1" style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                    </div>
                </div>
            </div>

            <!-- Barang yang Dipinjam -->
            <div class="card" style="padding: 24px; margin-bottom: 20px;">
                <h3 style="font-size: 16px; font-weight: 700; color: #1c1917; margin-bottom: 18px;">
                    <i class="fas fa-box" style="color: #fbbf24; margin-right: 6px;"></i>
                    Barang yang Dipinjam
                </h3>

                <div id="barang-list">
                    <div class="barang-row" style="display: grid; grid-template-columns: 1fr 120px 60px; gap: 12px; margin-bottom: 12px; align-items: end;">
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-size: 12px; font-weight: 600; color: #6b7280;">Barang</label>
                            <select name="barang_id[]" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                                <option value="">-- Pilih Barang --</option>
                                @foreach ($barang as $b)
                                    <option value="{{ $b->id_barang }}" data-stok="{{ $b->stok }}">
                                        {{ $b->nama_barang }} (Stok: {{ $b->stok }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-size: 12px; font-weight: 600; color: #6b7280;">Jumlah</label>
                            <input type="number" name="jumlah[]" value="1" min="1" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                        </div>
                        <button type="button" class="btn-remove" onclick="removeRow(this)" style="padding: 10px; background: #fee2e2; border: none; border-radius: 8px; color: #dc2626; cursor: pointer; font-size: 16px;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <button type="button" onclick="addRow()" style="padding: 10px 18px; background: #fef3c7; border: 2px dashed #fbbf24; border-radius: 10px; color: #92400e; font-weight: 700; cursor: pointer; font-family: inherit;">
                    <i class="fas fa-plus"></i> Tambah Barang
                </button>
            </div>

            <!-- Tombol -->
            <div style="display: flex; gap: 12px;">
                <button type="submit" style="padding: 12px 28px; background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); border: none; border-radius: 10px; color: white; font-weight: 700; cursor: pointer; font-family: inherit; box-shadow: 0 4px 12px rgba(251, 191, 36, 0.4);">
                    <i class="fas fa-save"></i> Simpan Peminjaman
                </button>
                <a href="{{ route('peminjaman.index') }}" style="padding: 12px 28px; background: #f3f4f6; border: none; border-radius: 10px; color: #374151; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        function addRow() {
            const list = document.getElementById('barang-list');
            const firstRow = list.querySelector('.barang-row');
            const newRow = firstRow.cloneNode(true);
            newRow.querySelector('select').value = '';
            newRow.querySelector('input[type="number"]').value = 1;
            list.appendChild(newRow);
        }

        function removeRow(btn) {
            const list = document.getElementById('barang-list');
            if (list.querySelectorAll('.barang-row').length > 1) {
                btn.closest('.barang-row').remove();
            } else {
                alert('Minimal 1 barang harus dipinjam.');
            }
        }
    </script>
@endsection