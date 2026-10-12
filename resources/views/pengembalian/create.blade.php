@extends('layouts.app')

@section('title', 'Tambah Pengembalian')

@section('content')
    <div style="max-width: 700px;">
        <h1 style="font-size: 24px; font-weight: 700; color: #1c1917; margin-bottom: 24px;">
            <i class="fas fa-check-circle" style="color: #fbbf24; margin-right: 8px;"></i>
            Catat Pengembalian
        </h1>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #dc2626;">
                <strong>Error:</strong>
                <ul style="margin: 8px 0 0 20px;">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pengembalian.store') }}" method="POST">
            @csrf

            <div class="card" style="padding: 24px; margin-bottom: 20px;">
                <div class="form-group" style="margin-bottom: 18px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Pilih Peminjaman</label>
                    <select name="id_peminjaman" id="id_peminjaman" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                        <option value="">-- Pilih Peminjaman Aktif --</option>
                        @foreach ($peminjaman as $p)
                            <option value="{{ $p->id_peminjaman }}"
                                    data-tanggal-pinjam="{{ $p->tanggal_pinjam }}"
                                    data-durasi="{{ $p->durasi_pinjam }}"
                                    data-status="{{ $p->status_pinjam }}">
                                #{{ $p->id_peminjaman }} - {{ $p->pengguna->nama ?? 'Tanpa Nama' }} ({{ $p->tanggal_pinjam }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="background: #fef3c7; padding: 14px 18px; border-radius: 10px; margin-bottom: 18px; display: none;" id="infoDenda">
                    <div style="font-size: 12px; color: #92400e; font-weight: 700; margin-bottom: 4px;">
                        <i class="fas fa-info-circle"></i> Info Keterlambatan
                    </div>
                    <div style="font-size: 13px; color: #78350f;" id="textDenda">
                        Belum dihitung.
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 18px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" id="tanggal_kembali" value="{{ date('Y-m-d') }}" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                </div>

                <div class="form-group" style="margin-bottom: 18px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Kondisi Barang</label>
                    <select name="kondisi_kembali" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                        <option value="baik">Baik</option>
                        <option value="rusak ringan">Rusak Ringan</option>
                        <option value="rusak berat">Rusak Berat</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151;">Petugas</label>
                    <select name="id_pegawai" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: inherit; background: #f9fafb;">
                        <option value="">-- Pilih Pegawai --</option>
                        @foreach ($pegawai as $p)
                            <option value="{{ $p->id_pegawai }}">{{ $p->nama_pegawai }} - {{ $p->jabatan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" style="padding: 12px 28px; background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); border: none; border-radius: 10px; color: white; font-weight: 700; cursor: pointer; font-family: inherit; box-shadow: 0 4px 12px rgba(251, 191, 36, 0.4);">
                    <i class="fas fa-save"></i> Simpan Pengembalian
                </button>
                <a href="{{ route('pengembalian.index') }}" style="padding: 12px 28px; background: #f3f4f6; border-radius: 10px; color: #374151; font-weight: 700; text-decoration: none;">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        const DENDA_PER_HARI = 5000;

        document.getElementById('id_peminjaman').addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            const infoBox = document.getElementById('infoDenda');
            const textBox = document.getElementById('textDenda');

            if (!opt.value) {
                infoBox.style.display = 'none';
                return;
            }

            const tglPinjam = new Date(opt.dataset.tanggalPinjam);
            const durasi = parseInt(opt.dataset.durasi) || 7;
            const tglHarusKembali = new Date(tglPinjam);
            tglHarusKembali.setDate(tglHarusKembali.getDate() + durasi);

            const tglKembali = new Date(document.getElementById('tanggal_kembali').value);

            infoBox.style.display = 'block';

            if (tglKembali > tglHarusKembali) {
                const selisihHari = Math.floor((tglKembali - tglHarusKembali) / (1000 * 60 * 60 * 24));
                const denda = selisihHari * DENDA_PER_HARI;
                textBox.innerHTML = '<strong>' + selisihHari + ' hari terlambat</strong> — Denda: <strong>Rp ' + denda.toLocaleString('id-ID') + '</strong>';
            } else {
                textBox.innerHTML = 'Tidak terlambat. Tidak ada denda.';
            }
        });

        document.getElementById('tanggal_kembali').addEventListener('change', function() {
            document.getElementById('id_peminjaman').dispatchEvent(new Event('change'));
        });
    </script>
@endsection