<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barangs';

    protected $fillable = [
        'kategori_satuan_id',
        'kode_barang',
        'nama_barang',
        'harga_beli',
        'harga_jual',
        'stok',
        'stok_minimum',
    ];

    public function kategoriSatuan(): BelongsTo
    {
        return $this->belongsTo(KategoriSatuan::class, 'kategori_satuan_id');
    }

    public function isStokMenipis(): bool
    {
        return $this->stok <= $this->stok_minimum;
    }

    public function scopeStokMenipis($query)
    {
        return $query->whereColumn('stok', '<=', 'stok_minimum');
    }
}