<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $nama
 * @property string $alamat
 * @property string $no_telp
 * @property \Carbon\Carbon $tanggal_lahir
 * @property string $jenis_kelamin
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|Kunjungan[] $kunjungan
 */
class Pasien extends Model
{
    protected $table = 'pasien';
    
    protected $fillable = [
        'nama',
        'alamat',
        'no_telp',
        'tanggal_lahir',
        'jenis_kelamin'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date'
    ];

    public function kunjungan(): HasMany
    {
        return $this->hasMany(Kunjungan::class);
    }
}
