<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRorisRequest;
use App\Models\Roris;
use App\Services\RorisCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RorisDetail;

class RorisController extends Controller
{
    /**
     * Daftar riwayat RORIS (pagination 10, filter tanggal).
     */
    public function index(Request $request)
    {
        $this->authorizeRole();

        $query = Roris::with('user')
            ->orderByDesc('tanggal')
            ->orderByDesc('id');

        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }

        $rorisList = $query->paginate(10)->withQueryString();

        return view('pemilik.roris.index', compact('rorisList'));
    }

    /**
     * Form input RORIS baru.
     */
    public function create()
    {
        $this->authorizeRole();

        return view('pemilik.roris.create');
    }

    /**
     * Simpan RORIS baru beserta rinciannya.
     */
    public function store(StoreRorisRequest $request)
    {
        $this->authorizeRole();

        $detailsRaw = collect($request->validated()['details']);

        // Hitung subtotal tiap baris
        $details = $detailsRaw->map(
            fn($item) => RorisCalculator::hitungDetail($item)
        );

        // Hitung header dari detail yang sudah dihitung
        $header = RorisCalculator::hitungHeader($details);

        DB::transaction(function () use ($request, $details, $header) {
            $roris = Roris::create([
                'tanggal' => $request->tanggal,
                'user_id' => auth()->id(),
                'catatan' => $request->catatan,
                'total_modal' => $header['total_modal'],
                'total_pendapatan' => $header['total_pendapatan'],
                'nilai_roris' => $header['nilai_roris'],
            ]);

            $roris->details()->createMany($details->toArray());
        });

        return redirect()->route('pemilik.roris.index')
            ->with('success', 'RORIS berhasil disimpan.');
    }

    /**
     * Detail satu RORIS beserta seluruh rinciannya.
     */
    public function show(Roris $roris)
    {
        $this->authorizeRole();

        $roris->load('details', 'user');

        return view('pemilik.roris.show', compact('roris'));
    }

    /**
     * Form edit RORIS.
     */
    public function edit(Roris $roris)
    {
        $this->authorizeRole();

        $roris->load('details');

        return view('pemilik.roris.edit', compact('roris'));
    }

    /**
     * Update RORIS beserta seluruh rinciannya.
     */
    public function update(StoreRorisRequest $request, Roris $roris)
    {
        $this->authorizeRole();

        $detailsRaw = collect($request->validated()['details']);

        $details = $detailsRaw->map(
            fn($item) => RorisCalculator::hitungDetail($item)
        );

        $header = RorisCalculator::hitungHeader($details);

        DB::transaction(function () use ($request, $roris, $details, $header) {
            $roris->update([
                'tanggal' => $request->tanggal,
                'catatan' => $request->catatan,
                'total_modal' => $header['total_modal'],
                'total_pendapatan' => $header['total_pendapatan'],
                'nilai_roris' => $header['nilai_roris'],
            ]);

            // Hapus rincian lama, kemudian simpan rincian terbaru.
            $roris->details()->delete();

            $roris->details()->createMany($details->toArray());
        });

        return redirect()->route('pemilik.roris.index')
            ->with('success', 'RORIS berhasil diperbarui.');
    }

    /**
     * Hapus RORIS beserta rinciannya.
     */
    public function destroy(Roris $roris)
    {
        $this->authorizeRole();

        DB::transaction(function () use ($roris) {
            $roris->details()->delete();
            $roris->delete();
        });

        return redirect()->route('pemilik.roris.index')
            ->with('success', 'RORIS berhasil dihapus.');
    }

    // Helper untuk memeriksa role pengguna
    private function authorizeRole(): void
    {
        if (!auth()->user()?->hasRole('pemilik_toko')) {
            abort(403, 'Akses Ditolak: Halaman ini hanya untuk Pemilik Toko.');
        }
    }
}
