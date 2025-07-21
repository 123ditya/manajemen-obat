<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resep;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\ResepObat;

class ResepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resep = Resep::with('kunjungan.pasien', 'resepObat.obat')->get();
        return view('resep.index', compact('resep'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kunjungan = Kunjungan::with('pasien')->whereDoesntHave('resep')->get();
        $obat = Obat::where('stok', '>', 0)->get();
        return view('resep.create', compact('kunjungan', 'obat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungan,id',
            'obat_ids' => 'required|array',
            'obat_ids.*' => 'exists:obat,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1'
        ]);

        $resep = Resep::create([
            'kunjungan_id' => $request->input('kunjungan_id')
        ]);

        foreach ($request->input('obat_ids') as $index => $obat_id) {
            /** @var Obat|null $obat */
            $obat = Obat::find($obat_id);
            $jumlah = $request->input('jumlah')[$index];
            
            if ($obat && $obat->stok >= $jumlah) {
                ResepObat::create([
                    'resep_id' => $resep->id,
                    'obat_id' => $obat_id,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $obat->harga
                ]);

                // Update stok obat
                $obat->decrement('stok', $jumlah);
            }
        }

        return redirect()->route('resep.index')->with('success', 'Resep berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $resep = Resep::with('kunjungan.pasien', 'resepObat.obat')->findOrFail($id);
        return view('resep.show', compact('resep'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $resep = Resep::with('resepObat.obat')->findOrFail($id);
        $obat = Obat::all();
        return view('resep.edit', compact('resep', 'obat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'obat_ids' => 'required|array',
            'obat_ids.*' => 'exists:obat,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1'
        ]);

        $resep = Resep::findOrFail($id);

        // Hapus resep obat lama dan kembalikan stok
        foreach ($resep->resepObat as $resepObat) {
            $obat = $resepObat->obat;
            $obat->increment('stok', $resepObat->jumlah);
            $resepObat->delete();
        }

        // Buat resep obat baru
        foreach ($request->input('obat_ids') as $index => $obat_id) {
            /** @var Obat|null $obat */
            $obat = Obat::find($obat_id);
            $jumlah = $request->input('jumlah')[$index];
            
            if ($obat && $obat->stok >= $jumlah) {
                ResepObat::create([
                    'resep_id' => $resep->id,
                    'obat_id' => $obat_id,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $obat->harga
                ]);

                $obat->decrement('stok', $jumlah);
            }
        }

        return redirect()->route('resep.index')->with('success', 'Resep berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resep = Resep::with('resepObat.obat')->findOrFail($id);

        // Kembalikan stok obat
        foreach ($resep->resepObat as $resepObat) {
            $obat = $resepObat->obat;
            $obat->increment('stok', $resepObat->jumlah);
        }

        $resep->delete();
        return redirect()->route('resep.index')->with('success', 'Resep berhasil dihapus');
    }

    /**
     * Get obat data for AJAX request
     */
    public function getObat($id)
    {
        $obat = Obat::find($id);
        return response()->json($obat);
    }
}
