<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Obat;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obat = [
            [
                'nama_obat' => 'Paracetamol',
                'kandungan' => 'Paracetamol 500mg',
                'harga' => 5000,
                'stok' => 100,
            ],
            [
                'nama_obat' => 'Amoxicillin',
                'kandungan' => 'Amoxicillin 500mg',
                'harga' => 15000,
                'stok' => 50,
            ],
            [
                'nama_obat' => 'Ibuprofen',
                'kandungan' => 'Ibuprofen 400mg',
                'harga' => 8000,
                'stok' => 75,
            ],
            [
                'nama_obat' => 'Omeprazole',
                'kandungan' => 'Omeprazole 20mg',
                'harga' => 25000,
                'stok' => 30,
            ],
            [
                'nama_obat' => 'Cetirizine',
                'kandungan' => 'Cetirizine 10mg',
                'harga' => 12000,
                'stok' => 60,
            ],
        ];

        foreach ($obat as $item) {
            Obat::create($item);
        }
    }
}
