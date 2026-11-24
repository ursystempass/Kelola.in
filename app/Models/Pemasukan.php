<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pemasukan extends Model
{
    protected $table = 'pemasukan_harian';

    protected $fillable = [
        'tanggal',
        'user_id',
        'metode_bayar',
        'total_pemasukan',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'         => 'date',
            'total_pemasukan' => 'decimal:2',
        ];
    }

    // Konstanta Metode Bayar 

    const METODE_TUNAI    = 'tunai';
    const METODE_TRANSFER = 'transfer';
    const METODE_QRIS     = 'qris';

    public function labelMetode(): string
    {
        return match ($this->metode_bayar) {
            self::METODE_TRANSFER => 'Transfer',
            self::METODE_QRIS     => 'QRIS',
            default               => 'Tunai',
        };
    }

    public function badgeMetodeClass(): string
    {
        return match ($this->metode_bayar) {
            self::METODE_TRANSFER => 'bg-indigo-50 text-indigo-700',
            self::METODE_QRIS     => 'bg-emerald-50 text-emerald-700',
            default               => 'bg-blue-50 text-blue-700',
        };
    }

    // Relasi 

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailPemasukan::class, 'pemasukan_harian_id');
    }
}