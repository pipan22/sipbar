@extends('layouts.app')

@section('title', 'Katalog Barang')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 700; color: #1c1917;">
                <i class="fas fa-search" style="color: #fbbf24; margin-right: 8px;"></i>
                Katalog Barang
            </h1>
            <p style="font-size: 13px; color: #6b7280; margin-top: 4px;">{{ $barang->count() }} barang tersedia</p>
        </div>
        <a href="{{ route('mahasiswa.peminjaman.create') }}" style="padding: 12px 24px; background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: white; border-radius: 10px; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(251, 191, 36, 0.4);">
            <i class="fas fa-plus"></i> Ajukan Peminjaman
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="card" style="padding: 20px; margin-bottom: 24px;">
        <form action="{{ route('mahasiswa.katalog') }}" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau merk barang..." style="flex: 1; min-width: 240px; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
            <select name="kategori" style="padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                <option value="">Semua Kategori</option>
                @foreach ($kategori as $k)
                    <option value="{{ $k->id_kategori }}" {{ request('kategori') == $k->id_kategori ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
            <button type="submit" style="padding: 10px 24px; background: linear-gradient(135deg, #fbbf24, #f59e0b); color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-family: inherit;">
                <i class="fas fa-search"></i> Cari
            </button>
        </form>
    </div>

    <!-- Grid Barang -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
        @forelse ($barang as $item)
            <div class="card" style="padding: 20px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 28px rgba(251, 191, 36, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #fbbf24, #f59e0b); display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);">
                        <i class="fas fa-box"></i>
                    </div>
                    <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                        Stok: {{ $item->stok }}
                    </span>
                </div>
                <h3 style="font-size: 15px; font-weight: 700; color: #1c1917; margin-bottom: 6px; line-height: 1.3;">{{ $item->nama_barang }}</h3>
                <p style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Merk: {{ $item->merk ?? '-' }}</p>
                <p style="font-size: 12px; color: #6b7280; margin-bottom: 12px;">Kategori: {{ $item->kategori->nama_kategori ?? '-' }}</p>
                <p style="font-size: 11px; color: #9ca3af; margin-bottom: 16px;"><i class="fas fa-map-marker-alt"></i> {{ $item->ruangan->nama_ruangan ?? '-' }}</p>
                <a href="{{ route('mahasiswa.peminjaman.create') }}" style="display: block; text-align: center; padding: 10px; background: #fef3c7; color: #92400e; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 13px;">
                    <i class="fas fa-hand-holding"></i> Pinjam Barang Ini
                </a>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px; color: #9ca3af;">
                <i class="fas fa-box-open" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                <p>Tidak ada barang yang cocok dengan pencarian.</p>
            </div>
        @endforelse
    </div>
@endsection