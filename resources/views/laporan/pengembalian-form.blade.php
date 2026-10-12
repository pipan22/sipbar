@extends('layouts.app')

@section('title', 'Cetak Laporan Pengembalian')

@section('content')
    <div style="max-width: 600px;">
        <h1 style="font-size: 24px; font-weight: 700; color: #1c1917; margin-bottom: 24px;">
            <i class="fas fa-check-circle" style="color: #fbbf24; margin-right: 8px;"></i>
            Cetak Laporan Pengembalian
        </h1>

        <form action="{{ route('laporan.pengembalian') }}" method="GET" target="_blank">
            <div class="card" style="padding: 28px;">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Dari Tanggal</label>
                    <input type="date" name="dari" style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                </div>
                <div style="margin-bottom: 24px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Sampai Tanggal</label>
                    <input type="date" name="sampai" style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                </div>
                <div style="display: flex; gap: 12px;">
                    <button type="submit" style="padding: 12px 28px; background: linear-gradient(135deg, #10b981, #059669); border: none; border-radius: 10px; color: white; font-weight: 700; cursor: pointer; font-family: inherit;">
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