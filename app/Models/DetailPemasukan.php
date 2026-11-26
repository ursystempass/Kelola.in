<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPemasukan extends Model
{
    protected $table = 'detail_pemasukan';

    protected $fillable = [
        'pemasukan_harian_id',
        'barang_id',
        'nama_barang',
        'satuan',
        'qty',
        'harga_satuan',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'qty' => 'decimal:2',
            'harga_satuan' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    // ─── Relasi ────────────────────────────────────────────────────────────────

    public function pemasukan(): BelongsTo
    {
        return $this->belongsTo(Pemasukan::class, 'pemasukan_harian_id');
    }
}