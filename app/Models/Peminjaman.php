<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    public $timestamps = false;
    protected $guarded = [];

    const DENDA_PER_HARI = 5000;

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    public function detail()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'id_peminjaman', 'id_peminjaman');
    }

    /**
     * Tanggal harus kembali = tanggal pinjam + durasi
     */
    public function getTanggalHarusKembaliAttribute()
    {
        return Carbon::parse($this->tanggal_pinjam)->addDays($this->durasi_pinjam ?? 7);
    }

    /**
     * Hari terlambat (0 kalau belum terlambat)
     */
    public function getHariTerlambatAttribute()
    {
        if ($this->status_pinjam === 'kembali') {
            return 0;
        }

        $harusKembali = $this->tanggal_harus_kembali;
        $hariIni = Carbon::now();

        if ($hariIni->lessThanOrEqualTo($harusKembali)) {
            return 0;
        }

        return (int) $harusKembali->diffInDays($hariIni);
    }

    /**
     * Denda = hari terlambat × DENDA_PER_HARI
     */
    public function getDendaAttribute()
    {
        return $this->hari_terlambat * self::DENDA_PER_HARI;
    }

    /**
 * Label status untuk ditampilkan
 */
public function getStatusLabelAttribute()
{
    $labels = [
        'menunggu' => 'Menunggu',
        'disetujui' => 'Disetujui',
        'dipinjam' => 'Dipinjam',
        'dikembalikan' => 'Dikembalikan',
        'terlambat' => 'Terlambat',
        'ditolak' => 'Ditolak',
    ];
    return $labels[$this->status_pinjam] ?? $this->status_pinjam;
}

    public function updateStatusOtomatis()
{
    // Hanya proses kalau statusnya 'dipinjam'
    if ($this->status_pinjam !== 'dipinjam') {
        return;
    }

    if ($this->hari_terlambat > 0) {
        $this->update(['status_pinjam' => 'terlambat']);
    }
}

/**
 * Cek kalau status sudah selesai (tidak bisa diubah lagi)
 */
public function isSelesai()
{
    return in_array($this->status_pinjam, ['dikembalikan', 'ditolak']);
}
}