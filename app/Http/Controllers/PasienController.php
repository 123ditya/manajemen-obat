<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pasien = Pasien::all();
        return view('pasien.index', compact('pasien'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pasien.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P'
        ]);

        Pasien::create($request->all());
        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pasien = Pasien::with('kunjungan.resep.resepObat.obat')->findOrFail($id);
        return view('pasien.show', compact('pasien'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasien.edit', compact('pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P'
        ]);

        $pasien = Pasien::findOrFail($id);
        $pasien->update($request->all());
        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();
        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil dihapus');
    }
}
