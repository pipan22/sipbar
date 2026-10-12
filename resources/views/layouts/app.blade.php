<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPBAR - Sistem Peminjaman Barang')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sipbar.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f0f9ff;
            color: #0f172a;
        }

        /* ============ SIDEBAR ============ */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #0a1f44 0%, #1e3a8a 50%, #0a1f44 100%);
            color: white;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(10, 31, 68, 0.15);
            z-index: 100;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(34, 211, 238, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-header .logo-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #06b6d4 0%, #22d3ee 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #0a1f44;
            box-shadow: 0 4px 12px rgba(34, 211, 238, 0.4);
        }

        .sidebar-header h2 {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: -0.3px;
            color: #22d3ee;
        }

        .sidebar-header p {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 2px;
        }

        .sidebar nav {
            padding: 16px 12px;
        }

        .sidebar .section-title {
            padding: 16px 12px 8px;
            font-size: 10px;
            text-transform: uppercase;
            color: rgba(34, 211, 238, 0.5);
            letter-spacing: 1.2px;
            font-weight: 600;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            border-radius: 8px;
            margin-bottom: 2px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar a i {
            width: 18px;
            font-size: 15px;
            text-align: center;
        }

        .sidebar a:hover {
            background: rgba(34, 211, 238, 0.1);
            color: #22d3ee;
            transform: translateX(4px);
        }

        .sidebar a.active {
            background: linear-gradient(135deg, #06b6d4 0%, #22d3ee 100%);
            color: #0a1f44;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(34, 211, 238, 0.4);
        }

        /* ============ MAIN CONTENT ============ */
        .main {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: white;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 50;
            border-bottom: 2px solid #e0f2fe;
        }

        .topbar h1 {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.4px;
        }

        .topbar .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            color: #475569;
        }

        .topbar .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #06b6d4 0%, #22d3ee 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0a1f44;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(34, 211, 238, 0.4);
        }

        .content {
            padding: 32px;
            flex: 1;
        }

        /* ============ CARDS ============ */
        .card {
            background: white;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 4px 16px rgba(34, 211, 238, 0.06);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(34, 211, 238, 0.1);
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(34, 211, 238, 0.15), 0 16px 40px rgba(34, 211, 238, 0.08);
        }

        /* ============ BUTTONS ============ */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            border: none;
            border-radius: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            color: white;
            transition: all 0.2s;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-add {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            margin-bottom: 20px;
        }
        .btn-edit { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        .btn-delete { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
        .btn-secondary { background: linear-gradient(135deg, #64748b 0%, #475569 100%); }

        /* ============ ALERTS ============ */
        .alert {
            padding: 14px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%);
            color: #164e63;
            font-weight: 500;
            font-size: 14px;
            border-left: 4px solid #06b6d4;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 2px 8px rgba(6, 182, 212, 0.15);
        }

        /* ============ TABLES ============ */
        .table-container {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 4px 16px rgba(34, 211, 238, 0.06);
            border: 1px solid rgba(34, 211, 238, 0.1);
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 14px 18px;
            text-align: left;
            font-size: 13.5px;
            border-bottom: 1px solid #f0f9ff;
        }

        th {
            background: linear-gradient(135deg, #0a1f44 0%, #1e3a8a 100%);
            color: #22d3ee;
            font-weight: 700;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f0fdfa; }

        /* ============ FORM ============ */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 13px;
            color: #334155;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            transition: all 0.2s;
            background: #f8fafc;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #06b6d4;
            background: white;
            box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.1);
        }

        /* ============ PAGE HEADER ============ */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .page-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .page-header p {
            font-size: 13px;
            color: #64748b;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
                <div class="sidebar-header">
            <img src="{{ asset('images/logo-sipbar.png') }}" alt="SIPBAR" style="height: 48px; width: auto;">
            <div>
                <h2>SIPBAR</h2>
                <p>Peminjaman Barang</p>
            </div>
        </div>

        <nav>
            @if(auth()->user()->role === 'mahasiswa')
                {{-- SIDEBAR MAHASISWA --}}
                <a href="{{ route('mahasiswa.dashboard') }}" class="{{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="{{ route('mahasiswa.katalog') }}" class="{{ request()->routeIs('mahasiswa.katalog') ? 'active' : '' }}">
                    <i class="fas fa-search"></i> Katalog Barang
                </a>
                <a href="{{ route('mahasiswa.peminjaman.index') }}" class="{{ request()->routeIs('mahasiswa.peminjaman.*') ? 'active' : '' }}" style="position: relative;">
                    <i class="fas fa-clipboard-list"></i> Peminjaman Saya
                    @php
                        $penggunaSidebar = \App\Models\Pengguna::where('username', auth()->user()->username)->first();
                        $notifMahasiswa = $penggunaSidebar 
                            ? \App\Models\Peminjaman::where('id_pengguna', $penggunaSidebar->id_pengguna)
                                                    ->whereIn('status_pinjam', ['disetujui', 'terlambat'])
                                                    ->count() 
                            : 0;
                    @endphp
                    @if($notifMahasiswa > 0)
                        <span style="position: absolute; top: 8px; right: 12px; background: #ef4444; color: white; font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 10px; min-width: 20px; text-align: center;">
                            {{ $notifMahasiswa }}
                        </span>
                    @endif
                </a>
            @else
                {{-- SIDEBAR ADMIN & PEGAWAI --}}
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>

                <div class="section-title">Master Data</div>
                <a href="{{ route('barang.index') }}" class="{{ request()->routeIs('barang.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i> Barang
                </a>
                <a href="{{ route('ruangan.index') }}" class="{{ request()->routeIs('ruangan.*') ? 'active' : '' }}">
                    <i class="fas fa-building"></i> Ruangan
                </a>

                @if(auth()->user()->role === 'admin')
                    <div class="section-title">Pengguna</div>
                    <a href="{{ route('pegawai.index') }}" class="{{ request()->routeIs('pegawai.*') ? 'active' : '' }}">
                        <i class="fas fa-user-tie"></i> Pegawai
                    </a>
                    <a href="{{ route('pengguna.index') }}" class="{{ request()->routeIs('pengguna.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Pengguna
                    </a>
                @endif

                <div class="section-title">Transaksi</div>
                <a href="{{ route('peminjaman.index') }}" class="{{ request()->routeIs('peminjaman.*') ? 'active' : '' }}" style="position: relative;">
                    <i class="fas fa-clipboard-list"></i> Peminjaman
                    @php
                        if (auth()->user()->role === 'pegawai') {
                            $notifCount = \App\Models\Peminjaman::whereIn('status_pinjam', ['disetujui', 'dipinjam', 'terlambat'])->count();
                            $notifColor = '#f59e0b';
                        } else {
                            $notifCount = \App\Models\Peminjaman::where('status_pinjam', 'menunggu')->count();
                            $notifColor = '#ef4444';
                        }
                    @endphp
                    @if($notifCount > 0)
                        <span style="position: absolute; top: 8px; right: 12px; background: {{ $notifColor }}; color: white; font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 10px; min-width: 20px; text-align: center;">
                            {{ $notifCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('pengembalian.index') }}" class="{{ request()->routeIs('pengembalian.*') ? 'active' : '' }}">
                    <i class="fas fa-check-circle"></i> Pengembalian
                </a>

                <div class="section-title">Laporan</div>
                <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <i class="fas fa-file-pdf"></i> Laporan
                </a>
            @endif
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main">
        <header class="topbar">
            <h1>@yield('title', 'Dashboard')</h1>
            <div class="user-info" style="display: flex; align-items: center; gap: 12px;">
                <div style="text-align: right;">
                    <div style="font-size: 13px; color: #334155;">
                        Halo, <strong>{{ Auth::user()->name ?? 'Guest' }}</strong>
                    </div>
                    @php
                        $roleColors = [
                            'admin' => ['#cffafe', '#0e7490'],
                            'pegawai' => ['#ddd6fe', '#5b21b6'],
                            'mahasiswa' => ['#bbf7d0', '#166534'],
                        ];
                        $rc = $roleColors[Auth::user()->role ?? 'admin'] ?? ['#e2e8f0', '#475569'];
                    @endphp
                    <div style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; background: {{ $rc[0] }}; color: {{ $rc[1] }}; padding: 2px 10px; border-radius: 10px; margin-top: 3px; display: inline-block;">
                        {{ Auth::user()->role ?? 'admin' }}
                    </div>
                </div>
                <div class="user-avatar">{{ substr(Auth::user()->name ?? 'G', 0, 1) }}</div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="padding: 8px 14px; background: #fee2e2; border: none; border-radius: 8px; color: #dc2626; font-weight: 600; font-size: 12px; cursor: pointer; font-family: inherit; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </header>

        <main class="content">
            @yield('content')
        </main>
    </div>
</body>
</html>