@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
    <div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 700; color: #0f172a;">
                <i class="fas fa-file-pdf" style="color: #06b6d4; margin-right: 8px;"></i>
                Laporan
            </h1>
            <p style="font-size: 13px; color: #64748b; margin-top: 4px;">Cetak laporan dalam format PDF</p>
        </div>
    </div>

    <!-- Statistik -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 32px;">
        <div class="card" style="border-left: 4px solid #06b6d4; padding: 20px;">
            <div style="font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Total Peminjaman</div>
            <div style="font-size: 32px; font-weight: 800; color: #0f172a; margin-top: 6px; letter-spacing: -1px;">{{ $totalPeminjaman }}</div>
        </div>
        <div class="card" style="border-left: 4px solid #10b981; padding: 20px;">
            <div style="font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Sudah Kembali</div>
            <div style="font-size: 32px; font-weight: 800; color: #0f172a; margin-top: 6px; letter-spacing: -1px;">{{ $totalPengembalian }}</div>
        </div>
        <div class="card" style="border-left: 4px solid #8b5cf6; padding: 20px;">
            <div style="font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Belum Kembali</div>
            <div style="font-size: 32px; font-weight: 800; color: #0f172a; margin-top: 6px; letter-spacing: -1px;">{{ $peminjamanAktif }}</div>
        </div>
        <div class="card" style="border-left: 4px solid #ef4444; padding: 20px;">
            <div style="font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Total Denda</div>
            <div style="font-size: 20px; font-weight: 800; color: #dc2626; margin-top: 10px;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Card Laporan -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
        <!-- Laporan Peminjaman -->
        <div class="card" style="padding: 28px;">
            <div style="width: 56px; height: 56px; border-radius: 14px; background: linear-gradient(135deg, #06b6d4, #22d3ee); display: flex; align-items: center; justify-content: center; color: white; font-size: 22px; margin-bottom: 20px; box-shadow: 0 8px 20px rgba(6, 182, 212, 0.35);">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 10px;">Laporan Peminjaman</h3>
            <p style="font-size: 14px; color: #64748b; margin-bottom: 20px; line-height: 1.6;">
                Cetak semua transaksi peminjaman, filter berdasarkan tanggal dan status.
            </p>
            <a href="{{ route('laporan.peminjaman.form') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: linear-gradient(135deg, #06b6d4, #22d3ee); color: white; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 14px; box-shadow: 0 4px 12px rgba(6, 182, 212, 0.35);">
                <i class="fas fa-print"></i> Cetak PDF
            </a>
        </div>

        <!-- Laporan Pengembalian -->
        <div class="card" style="padding: 28px;">
            <div style="width: 56px; height: 56px; border-radius: 14px; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; color: white; font-size: 22px; margin-bottom: 20px; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35);">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 10px;">Laporan Pengembalian</h3>
            <p style="font-size: 14px; color: #64748b; margin-bottom: 20px; line-height: 1.6;">
                Cetak transaksi pengembalian + total denda, filter berdasarkan tanggal.
            </p>
            <a href="{{ route('laporan.pengembalian.form') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: linear-gradient(135deg, #10b981, #059669); color: white; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 14px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);">
                <i class="fas fa-print"></i> Cetak PDF
            </a>
        </div>

        <!-- Laporan Stok Barang -->
        <div class="card" style="padding: 28px;">
            <div style="width: 56px; height: 56px; border-radius: 14px; background: linear-gradient(135deg, #8b5cf6, #a78bfa); display: flex; align-items: center; justify-content: center; color: white; font-size: 22px; margin-bottom: 20px; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.35);">
                <i class="fas fa-box"></i>
            </div>
            <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 10px;">Laporan Stok Barang</h3>
            <p style="font-size: 14px; color: #64748b; margin-bottom: 20px; line-height: 1.6;">
                Cetak daftar semua barang beserta stok saat ini.
            </p>
            <a href="{{ route('laporan.barang') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: linear-gradient(135deg, #8b5cf6, #a78bfa); color: white; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 14px; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.35);">
                <i class="fas fa-print"></i> Cetak PDF
            </a>
        </div>
    </div>
@endsection