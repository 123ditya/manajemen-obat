<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $nama_obat
 * @property string $kandungan
 * @property float $harga
 * @property int $stok
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Obat extends Model
{
    protected $table = 'obat';
    
    protected $fillable = [
        'nama_obat',
        'kandungan',
        'harga',
        'stok'
    ];

    public function resepObat(): HasMany
    {
        return $this->hasMany(ResepObat::class);
    }
}
