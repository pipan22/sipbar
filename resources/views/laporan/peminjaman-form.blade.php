@extends('layouts.app')

@section('title', 'Cetak Laporan Peminjaman')

@section('content')
    <div style="max-width: 600px;">
        <h1 style="font-size: 24px; font-weight: 700; color: #1c1917; margin-bottom: 24px;">
            <i class="fas fa-clipboard-list" style="color: #fbbf24; margin-right: 8px;"></i>
            Cetak Laporan Peminjaman
        </h1>

        <form action="{{ route('laporan.peminjaman') }}" method="GET" target="_blank">
            <div class="card" style="padding: 28px;">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Dari Tanggal</label>
                    <input type="date" name="dari" style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Sampai Tanggal</label>
                    <input type="date" name="sampai" style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Status</label>
                    <select name="status" style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                        <option value="semua">Semua Status</option>
                        <option value="dipinjam">Dipinjam</option>
                        <option value="kembali">Kembali</option>
                        <option value="terlambat">Terlambat</option>
                    </select>
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="submit" style="padding: 12px 28px; background: linear-gradient(135deg, #fbbf24, #f59e0b); border: none; border-radius: 10px; color: white; font-weight: 700; cursor: pointer; font-family: inherit; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-file-pdf"></i> Cetak PDF
                    </button>
                    <a href="{{ route('laporan.index') }}" style="padding: 12px 28px; background: #f3f4f6; border-radius: 10px; color: #374151; font-weight: 700; text-decoration: none;">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection