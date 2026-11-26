<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Roris;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanRorisExport;

class LaporanRorisController extends Controller
{
    /**
     * Halaman laporan RORIS (form filter + rekap).
     */
    public function index(Request $request)
    {
        $this->authorizePermission('lihat-laporan-roris');

        $rorisList = collect();
        $totalModal = $totalPendapatan = $nilaiRoris = 0;
        $validated = false;
        $errors = [];

        if ($request->filled('dari') || $request->filled('sampai')) {
            // Validasi
            $dari = $request->dari ?? null;
            $sampai = $request->sampai ?? null;

            if (!$dari || !$sampai) {
                $errors[] = 'Tanggal awal dan tanggal akhir wajib diisi.';
            } elseif ($dari > $sampai) {
                $errors[] = 'Tanggal awal tidak boleh lebih besar dari tanggal akhir.';
            } else {
                $validated = true;
                $rorisList = Roris::with(['user', 'details'])
                    ->whereDate('tanggal', '>=', $dari)
                    ->whereDate('tanggal', '<=', $sampai)
                    ->orderBy('tanggal')
                    ->get();

                $totalModal = $rorisList->sum('total_modal');
                $totalPendapatan = $rorisList->sum('total_pendapatan');
                $nilaiRoris = $rorisList->sum('nilai_roris');
            }
        }

        return view('pemilik.laporan-roris.index', compact(
            'rorisList',
            'totalModal',
            'totalPendapatan',
            'nilaiRoris',
            'validated',
            'errors'
        ));
    }

    /**
     * Cetak laporan RORIS dalam format PDF.
     */
    public function pdf(Request $request)
    {
        $this->authorizePermission('lihat-laporan-roris');

        $dari = $request->dari ?? null;
        $sampai = $request->sampai ?? null;

        if (!$dari || !$sampai || $dari > $sampai) {
            return redirect()->route('pemilik.roris.laporan')
                ->withErrors(['dari' => 'Periode tidak valid untuk cetak PDF.']);
        }

        $rorisList = Roris::with(['user', 'details'])
            ->whereDate('tanggal', '>=', $dari)
            ->whereDate('tanggal', '<=', $sampai)
            ->orderBy('tanggal')
            ->get();

        $totalModal = $rorisList->sum('total_modal');
        $totalPendapatan = $rorisList->sum('total_pendapatan');
        $nilaiRoris = $rorisList->sum('nilai_roris');

        $pdf = Pdf::loadView('pemilik.laporan-roris.pdf', compact(
            'rorisList',
            'totalModal',
            'totalPendapatan',
            'nilaiRoris',
            'dari',
            'sampai'
        ))->setPaper('a4', 'landscape');

        $filename = 'Laporan_RORIS_' . $dari . '_sd_' . $sampai . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Ekspor laporan RORIS dalam format Excel.
     */
    public function excel(Request $request)
    {
        $this->authorizePermission('lihat-laporan-roris');

        $dari = $request->dari ?? null;
        $sampai = $request->sampai ?? null;

        if (!$dari || !$sampai || $dari > $sampai) {
            return redirect()->route('pemilik.roris.laporan')
                ->withErrors(['dari' => 'Periode tidak valid untuk ekspor Excel.']);
        }

        $filename = 'Laporan_RORIS_' . $dari . '_sd_' . $sampai . '.xlsx';

        return Excel::download(new LaporanRorisExport($dari, $sampai), $filename);
    }

    // ─── Helper ────────────────────────────────────────────────────────────────

    private function authorizePermission(string $slug): void
    {
        if (!auth()->user()?->hasRole('pemilik_toko')) {
            abort(403, 'Akses Ditolak: Halaman ini hanya untuk Pemilik Toko.');
        }
    }
}
