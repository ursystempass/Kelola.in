<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Roris;
use Illuminate\Http\JsonResponse;

class DashboardRorisController extends Controller
{
    /**
     * Endpoint data grafik RORIS untuk dashboard Pemilik Toko.
     * Mengembalikan JSON: label (tanggal) dan nilai_roris, maks 12 RORIS terakhir.
     */
    public function grafik(): JsonResponse
    {
        if (! auth()->user()?->hasRole('pemilik_toko')) {
            abort(403);
        }

        $data = Roris::orderByDesc('tanggal')
            ->orderByDesc('id')
            ->limit(12)
            ->get(['tanggal', 'nilai_roris'])
            ->reverse()
            ->values();

        return response()->json([
            'labels' => $data->map(fn ($r) => $r->tanggal->format('d/m/Y')),
            'values' => $data->map(fn ($r) => (float) $r->nilai_roris),
        ]);
    }
}
