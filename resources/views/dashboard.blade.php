@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    {{-- BANNER ADMIN --}}
    @if(auth()->user()->role === 'admin')
        @php
            $pendingCount = \App\Models\Peminjaman::where('status_pinjam', 'menunggu')->count();
        @endphp

        @if($pendingCount > 0)
            <div style="background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%); border-radius: 16px; padding: 20px 24px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; border-left: 4px solid #06b6d4; box-shadow: 0 4px 12px rgba(6, 182, 212, 0.15); flex-wrap: wrap; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: white; display: flex; align-items: center; justify-content: center; color: #0891b2; font-size: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div>
                        <h3 style="font-size: 16px; font-weight: 700; color: #164e63; margin-bottom: 2px;">
                            {{ $pendingCount }} peminjaman menunggu verifikasi
                        </h3>
                        <p style="font-size: 13px; color: #0e7490;">Pengajuan dari mahasiswa perlu disetujui atau ditolak.</p>
                    </div>
                </div>
                <a href="{{ route('peminjaman.index', ['status' => 'menunggu']) }}" style="padding: 10px 20px; background: #0891b2; color: white; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 13px;">
                    <i class="fas fa-check-circle"></i> Verifikasi
                </a>
            </div>
        @endif
    @endif

    {{-- BANNER PEGAWAI --}}
    @if(auth()->user()->role === 'pegawai')
        @php
            $siapSerah = \App\Models\Peminjaman::where('status_pinjam', 'disetujui')->count();
            $perluTerima = \App\Models\Peminjaman::whereIn('status_pinjam', ['dipinjam', 'terlambat'])->count();
        @endphp

        @if($siapSerah > 0)
            <div style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 16px; padding: 20px 24px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; border-left: 4px solid #6366f1; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15); flex-wrap: wrap; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: white; display: flex; align-items: center; justify-content: center; color: #4338ca; font-size: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <i class="fas fa-hand-holding"></i>
                    </div>
                    <div>
                        <h3 style="font-size: 16px; font-weight: 700; color: #3730a3; margin-bottom: 2px;">
                            {{ $siapSerah }} peminjaman siap serah terima
                        </h3>
                        <p style="font-size: 13px; color: #4338ca;">Barang perlu diserahkan ke mahasiswa.</p>
                    </div>
                </div>
                <a href="{{ route('peminjaman.index', ['status' => 'disetujui']) }}" style="padding: 10px 20px; background: #6366f1; color: white; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 13px;">
                    <i class="fas fa-hand-holding"></i> Serah Terima
                </a>
            </div>
        @endif

        @if($perluTerima > 0)
            <div style="background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%); border-radius: 16px; padding: 20px 24px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; border-left: 4px solid #06b6d4; box-shadow: 0 4px 12px rgba(6, 182, 212, 0.15); flex-wrap: wrap; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: white; display: flex; align-items: center; justify-content: center; color: #0891b2; font-size: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <div>
                        <h3 style="font-size: 16px; font-weight: 700; color: #164e63; margin-bottom: 2px;">
                            {{ $perluTerima }} peminjaman perlu diterima kembali
                        </h3>
                        <p style="font-size: 13px; color: #0e7490;">Barang perlu diterima dari mahasiswa.</p>
                    </div>
                </div>
                <a href="{{ route('peminjaman.index', ['status' => 'dipinjam']) }}" style="padding: 10px 20px; background: #0891b2; color: white; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 13px;">
                    <i class="fas fa-check-double"></i> Terima Kembali
                </a>
            </div>
        @endif
    @endif

    {{-- Statistik Cards --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 28px;">
        <!-- Total Barang -->
        <div class="card" style="border-left: 4px solid #06b6d4; padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Total Barang</div>
                    <div style="font-size: 32px; font-weight: 800; color: #0f172a; margin: 6px 0; letter-spacing: -1px;">{{ $totalBarang }}</div>
                    <div style="font-size: 12px; color: #94a3b8;">Jenis barang terdaftar</div>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #06b6d4 0%, #22d3ee 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; box-shadow: 0 4px 12px rgba(6, 182, 212, 0.4);">
                    <i class="fas fa-box"></i>
                </div>
            </div>
        </div>

        <!-- Total Pengguna -->
        <div class="card" style="border-left: 4px solid #0891b2; padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Total Pengguna</div>
                    <div style="font-size: 32px; font-weight: 800; color: #0f172a; margin: 6px 0; letter-spacing: -1px;">{{ $totalPengguna }}</div>
                    <div style="font-size: 12px; color: #94a3b8;">Akun peminjam</div>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; box-shadow: 0 4px 12px rgba(8, 145, 178, 0.4);">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <!-- Peminjaman Aktif -->
        <div class="card" style="border-left: 4px solid #a78bfa; padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Peminjaman Aktif</div>
                    <div style="font-size: 32px; font-weight: 800; color: #0f172a; margin: 6px 0; letter-spacing: -1px;">{{ $peminjamanAktif }}</div>
                    <div style="font-size: 12px; color: #94a3b8;">Sedang dipinjam</div>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; box-shadow: 0 4px 12px rgba(167, 139, 250, 0.4);">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>

        <!-- Total Peminjaman -->
        <div class="card" style="border-left: 4px solid #8b5cf6; padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Total Peminjaman</div>
                    <div style="font-size: 32px; font-weight: 800; color: #0f172a; margin: 6px 0; letter-spacing: -1px;">{{ $totalPeminjaman }}</div>
                    <div style="font-size: 12px; color: #94a3b8;">Semua transaksi</div>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Peminjaman Terbaru --}}
    <div class="card" style="padding: 0; overflow: hidden;">
        <div style="padding: 20px 24px; border-bottom: 1px solid #e0f2fe;">
            <h3 style="font-size: 16px; font-weight: 700; color: #0f172a;">
                <i class="fas fa-clipboard-list" style="color: #06b6d4; margin-right: 8px;"></i>
                Peminjaman Terbaru
            </h3>
        </div>
        <div class="table-container" style="border-radius: 0; box-shadow: none; border: none;">
            <table>
                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamanTerbaru as $p)
                        <tr>
                            <td>{{ $p->pengguna->nama ?? '-' }}</td>
                            <td>{{ $p->tanggal_pinjam }}</td>
                            <td>
                                @php
                                    $colors = [
                                        'menunggu'      => ['#cffafe', '#0e7490'],
                                        'disetujui'     => ['#e0e7ff', '#4338ca'],
                                        'dipinjam'      => ['#dbeafe', '#1e40af'],
                                        'dikembalikan'  => ['#d1fae5', '#065f46'],
                                        'terlambat'     => ['#fee2e2', '#991b1b'],
                                        'ditolak'       => ['#f1f5f9', '#475569'],
                                    ];
                                    $c = $colors[$p->status_pinjam] ?? ['#f1f5f9', '#475569'];
                                @endphp
                                <span style="background: {{ $c[0] }}; color: {{ $c[1] }}; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: capitalize;">
                                    {{ $p->status_pinjam }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" style="text-align: center; color: #94a3b8; padding: 30px;">Belum ada peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection