<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::all();
        return view('pengguna.index', compact('pengguna'));
    }

    public function create()
    {
        return view('pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:pengguna,username',
            'password' => 'required|string|min:6',
            'email'    => 'required|email|max:100|unique:pengguna,email',
        ]);

        Pengguna::create([
            'nama'     => $request->nama,
            'username' => $request->username,
            'password' => $request->password,
            'email'    => $request->email,
        ]);

        return redirect()->route('pengguna.index')
                         ->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        return view('pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:pengguna,username,' . $id . ',id_pengguna',
            'password' => 'nullable|string|min:6',
            'email'    => 'required|email|max:100|unique:pengguna,email,' . $id . ',id_pengguna',
        ]);

        $pengguna = Pengguna::findOrFail($id);
        $data = [
            'nama'     => $request->nama,
            'username' => $request->username,
            'email'    => $request->email,
        ];

        // Kalau password diisi, update. Kalau kosong, biarkan lama.
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $pengguna->update($data);

        return redirect()->route('pengguna.index')
                         ->with('success', 'Pengguna berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->delete();

        return redirect()->route('pengguna.index')
                         ->with('success', 'Pengguna berhasil dihapus!');
    }
}