<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $kunjungan_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property Kunjungan $kunjungan
 * @property \Illuminate\Database\Eloquent\Collection|ResepObat[] $resepObat
 */
class Resep extends Model
{
    protected $table = 'resep';
    
    protected $fillable = [
        'kunjungan_id'
    ];

    public function kunjungan(): BelongsTo
    {
        return $this->belongsTo(Kunjungan::class);
    }

    public function resepObat(): HasMany
    {
        return $this->hasMany(ResepObat::class);
    }
}
