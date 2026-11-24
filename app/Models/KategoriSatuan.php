<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriSatuan extends Model
{
    use HasFactory;

    protected $table = 'kategori_satuans';

    protected $fillable = [
        'nama_satuan',
        'deskripsi',
    ];

    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class, 'kategori_satuan_id');
    }
}