<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $pasien_id
 * @property \Carbon\Carbon $tanggal_kunjungan
 * @property string $keluhan
 * @property string $diagnosa
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property Pasien $pasien
 * @property Resep|null $resep
 */
class Kunjungan extends Model
{
    protected $table = 'kunjungan';
    
    protected $fillable = [
        'pasien_id',
        'tanggal_kunjungan',
        'keluhan',
        'diagnosa'
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date'
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function resep(): HasOne
    {
        return $this->hasOne(Resep::class);
    }
}
