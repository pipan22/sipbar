<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with('kategori', 'ruangan')->get();
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $kategori = KategoriBarang::all();
        $ruangan = Ruangan::all();
        return view('barang.create', compact('kategori', 'ruangan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'merk'        => 'nullable|string|max:50',
            'stok'        => 'nullable|integer|min:0',
            'id_kategori' => 'nullable|exists:kategori_barang,id_kategori',
            'id_ruangan'  => 'nullable|exists:ruangan,id_ruangan',
        ]);

        Barang::create($request->all());

        return redirect()->route('barang.index')
                         ->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategori = KategoriBarang::all();
        $ruangan = Ruangan::all();
        return view('barang.edit', compact('barang', 'kategori', 'ruangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'merk'        => 'nullable|string|max:50',
            'stok'        => 'nullable|integer|min:0',
            'id_kategori' => 'nullable|exists:kategori_barang,id_kategori',
            'id_ruangan'  => 'nullable|exists:ruangan,id_ruangan',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('barang.index')
                         ->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')
                         ->with('success', 'Barang berhasil dihapus!');
    }
}