<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $resep_id
 * @property int $obat_id
 * @property int $jumlah
 * @property float $harga_satuan
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property Resep $resep
 * @property Obat $obat
 */
class ResepObat extends Model
{
    protected $table = 'resep_obat';
    
    protected $fillable = [
        'resep_id',
        'obat_id',
        'jumlah',
        'harga_satuan'
    ];

    public function resep(): BelongsTo
    {
        return $this->belongsTo(Resep::class);
    }

    public function obat(): BelongsTo
    {
        return $this->belongsTo(Obat::class);
    }
}
