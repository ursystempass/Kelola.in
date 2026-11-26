<?php

namespace App\Services;

use App\Models\Roris;
use Illuminate\Support\Collection;

/**
 * RorisCalculator
 *
 * Semua perhitungan RORIS ada di sini (satu tempat).
 * Tidak ada kalkulasi yang dilakukan di controller atau view.
 */
class RorisCalculator
{
    /**
     * Hitung subtotal per baris detail dari data mentah (array/collection).
     *
     * @param  array  $item  ['qty_fisik', 'harga_modal', 'harga_jual']
     * @return array  Ditambah subtotal_modal dan subtotal_pendapatan
     */
    public static function hitungDetail(array $item): array
    {
        $qty   = (float) ($item['qty_fisik'] ?? 0);
        $modal = (float) ($item['harga_modal'] ?? 0);
        $jual  = (float) ($item['harga_jual'] ?? 0);

        $item['subtotal_modal']      = round($qty * $modal, 2);
        $item['subtotal_pendapatan'] = round($qty * $jual, 2);

        return $item;
    }

    /**
     * Hitung ringkasan header dari kumpulan detail yang sudah dihitung.
     *
     * @param  Collection|array  $details  Tiap elemen harus punya subtotal_modal & subtotal_pendapatan
     * @return array  ['total_modal', 'total_pendapatan', 'nilai_roris']
     */
    public static function hitungHeader(Collection|array $details): array
    {
        $totalModal      = 0;
        $totalPendapatan = 0;

        foreach ($details as $d) {
            $totalModal      += (float) ($d['subtotal_modal']      ?? $d->subtotal_modal      ?? 0);
            $totalPendapatan += (float) ($d['subtotal_pendapatan'] ?? $d->subtotal_pendapatan ?? 0);
        }

        return [
            'total_modal'      => round($totalModal, 2),
            'total_pendapatan' => round($totalPendapatan, 2),
            'nilai_roris'      => round($totalPendapatan - $totalModal, 2),
        ];
    }

    /**
     * Hitung ringkasan dari model Roris yang sudah dimuat dengan relasi details.
     */
    public static function hitungDariModel(Roris $roris): array
    {
        return self::hitungHeader($roris->details);
    }
}
