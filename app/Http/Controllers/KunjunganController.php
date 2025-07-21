<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Pasien;

class KunjunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kunjungan = Kunjungan::with('pasien')->get();
        return view('kunjungan.index', compact('kunjungan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pasien = Pasien::all();
        return view('kunjungan.create', compact('pasien'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'tanggal_kunjungan' => 'required|date',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string'
        ]);

        Kunjungan::create($request->all());
        return redirect()->route('kunjungan.index')->with('success', 'Kunjungan berhasil dicatat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kunjungan = Kunjungan::with('pasien', 'resep.resepObat.obat')->findOrFail($id);
        return view('kunjungan.show', compact('kunjungan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kunjungan = Kunjungan::findOrFail($id);
        $pasien = Pasien::all();
        return view('kunjungan.edit', compact('kunjungan', 'pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'tanggal_kunjungan' => 'required|date',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string'
        ]);

        $kunjungan = Kunjungan::findOrFail($id);
        $kunjungan->update($request->all());
        return redirect()->route('kunjungan.index')->with('success', 'Kunjungan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kunjungan = Kunjungan::findOrFail($id);
        $kunjungan->delete();
        return redirect()->route('kunjungan.index')->with('success', 'Kunjungan berhasil dihapus');
    }
}
