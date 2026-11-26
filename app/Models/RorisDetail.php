<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RorisDetail extends Model
{
    protected $table = 'roris_details';

    protected $fillable = [
        'roris_id',
        'kode_barang',
        'nama_barang',
        'satuan',
        'qty_fisik',
        'harga_modal',
        'harga_jual',
        'subtotal_modal',
        'subtotal_pendapatan',
    ];

    protected function casts(): array
    {
        return [
            'qty_fisik'           => 'decimal:2',
            'harga_modal'         => 'decimal:2',
            'harga_jual'          => 'decimal:2',
            'subtotal_modal'      => 'decimal:2',
            'subtotal_pendapatan' => 'decimal:2',
        ];
    }

    // ─── Relasi ────────────────────────────────────────────────────────────────

    public function roris(): BelongsTo
    {
        return $this->belongsTo(Roris::class);
    }
}
