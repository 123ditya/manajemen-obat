<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Obat;
use App\Models\Kunjungan;
use App\Models\Resep;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_pasien' => Pasien::count(),
            'total_obat' => Obat::count(),
            'kunjungan_hari_ini' => Kunjungan::whereDate('tanggal_kunjungan', today())->count(),
            'total_resep' => Resep::count(),
            'obat_tersedia' => Obat::where('stok', '>', 0)->count(),
            'obat_habis' => Obat::where('stok', 0)->count(),
        ];

        return view('dashboard', $data);
    }
}
