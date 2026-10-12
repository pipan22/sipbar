<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';
    public $timestamps = false;
    protected $guarded = [];

    public function ruangan()
    {
        return $this->hasMany(Ruangan::class, 'id_pegawai', 'id_pegawai');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_pegawai', 'id_pegawai');
    }
}