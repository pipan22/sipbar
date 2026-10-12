<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::with('pegawai')->get();
        return view('ruangan.index', compact('ruangan'));
    }

    public function create()
    {
        $pegawai = Pegawai::all();
        return view('ruangan.create', compact('pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:100',
            'lantai'       => 'nullable|integer',
            'id_pegawai'   => 'nullable|exists:pegawai,id_pegawai',
            'keterangan'   => 'nullable|string',
        ]);

        Ruangan::create($request->all());

        return redirect()->route('ruangan.index')
                         ->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $pegawai = Pegawai::all();
        return view('ruangan.edit', compact('ruangan', 'pegawai'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:100',
            'lantai'       => 'nullable|integer',
            'id_pegawai'   => 'nullable|exists:pegawai,id_pegawai',
            'keterangan'   => 'nullable|string',
        ]);

        $ruangan = Ruangan::findOrFail($id);
        $ruangan->update($request->all());

        return redirect()->route('ruangan.index')
                         ->with('success', 'Ruangan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();

        return redirect()->route('ruangan.index')
                         ->with('success', 'Ruangan berhasil dihapus!');
    }
}