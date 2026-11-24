<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePemasukanRequest;
use App\Http\Requests\UpdatePemasukanRequest;
use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemasukanController extends Controller
{
    /**
     * Daftar pemasukan harian sekaligus perhitungan total per tanggal.
     */
    public function index(Request $request)
    {
        $this->authorizeRole();

        $tanggal = $request->input('tanggal', now()->toDateString());

        $baseQuery = Pemasukan::whereDate('tanggal', $tanggal);

        $totalHarian     = (clone $baseQuery)->sum('total_pemasukan');
        $jumlahTransaksi = (clone $baseQuery)->count();
        $totalTunai      = (clone $baseQuery)->where('metode_bayar', Pemasukan::METODE_TUNAI)->sum('total_pemasukan');
        $totalNonTunai   = (clone $baseQuery)->whereIn('metode_bayar', [
            Pemasukan::METODE_TRANSFER,
            Pemasukan::METODE_QRIS,
        ])->sum('total_pemasukan');

        $pemasukanList = (clone $baseQuery)
            ->with('user')
            ->withCount('details')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('pemilik.pemasukan.index', compact(
            'tanggal',
            'totalHarian',
            'jumlahTransaksi',
            'totalTunai',
            'totalNonTunai',
            'pemasukanList'
        ));
    }

    /**
     * Riwayat seluruh pemasukan dengan filter rentang tanggal dan metode bayar.
     */
    public function riwayat(Request $request)
    {
        $this->authorizeRole();

        $query = Pemasukan::with('user')
            ->withCount('details')
            ->orderByDesc('tanggal')
            ->orderByDesc('id');

        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }
        if ($request->filled('metode_bayar') && in_array($request->metode_bayar, [
            Pemasukan::METODE_TUNAI,
            Pemasukan::METODE_TRANSFER,
            Pemasukan::METODE_QRIS,
        ])) {
            $query->where('metode_bayar', $request->metode_bayar);
        }

        $totalPeriode  = (clone $query)->sum('total_pemasukan');
        $pemasukanList = $query->paginate(10)->withQueryString();

        return view('pemilik.pemasukan.riwayat', compact('pemasukanList', 'totalPeriode'));
    }

    /**
     * Form catat pemasukan baru.
     */
    public function create()
    {
        $this->authorizeRole();

        return view('pemilik.pemasukan.create');
    }

    /**
     * Simpan pemasukan baru beserta rincian barangnya.
     */
    public function store(StorePemasukanRequest $request)
    {
        $details = collect($request->validated()['details'])->map(function ($item) {
            $subtotal = (float) $item['qty'] * (float) $item['harga_satuan'];

            return [
                'nama_barang'  => $item['nama_barang'],
                'satuan'       => $item['satuan'],
                'qty'          => $item['qty'],
                'harga_satuan' => $item['harga_satuan'],
                'subtotal'     => $subtotal,
            ];
        });

        $totalPemasukan = $details->sum('subtotal');

        DB::transaction(function () use ($request, $details, $totalPemasukan) {
            $pemasukan = Pemasukan::create([
                'tanggal'         => $request->tanggal,
                'user_id'         => auth()->id(),
                'metode_bayar'    => $request->metode_bayar,
                'total_pemasukan' => $totalPemasukan,
                'catatan'         => $request->catatan,
            ]);

            $pemasukan->details()->createMany($details->toArray());
        });

        return redirect()->route('pemilik.pemasukan.index', ['tanggal' => $request->tanggal])
            ->with('success', 'Data pemasukan berhasil disimpan.');
    }

    /**
     * Detail satu transaksi pemasukan beserta seluruh rincian barangnya.
     */
    public function show(Pemasukan $pemasukan)
    {
        $this->authorizeRole();

        $pemasukan->load('details', 'user');

        return view('pemilik.pemasukan.show', compact('pemasukan'));
    }

/**
     * Form ubah data pemasukan.
     */
    public function edit(Pemasukan $pemasukan)
    {
        $this->authorizeRole();

        $pemasukan->load('details');

        return view('pemilik.pemasukan.edit', compact('pemasukan'));
    }

    /**
     * Perbarui data pemasukan beserta rincian barangnya.
     */
    public function update(UpdatePemasukanRequest $request, Pemasukan $pemasukan)
    {
        $details = collect($request->validated()['details'])->map(function ($item) {
            $subtotal = (float) $item['qty'] * (float) $item['harga_satuan'];

            return [
                'nama_barang'  => $item['nama_barang'],
                'satuan'       => $item['satuan'],
                'qty'          => $item['qty'],
                'harga_satuan' => $item['harga_satuan'],
                'subtotal'     => $subtotal,
            ];
        });

        $totalPemasukan = $details->sum('subtotal');

        DB::transaction(function () use ($request, $pemasukan, $details, $totalPemasukan) {
            $pemasukan->update([
                'tanggal'         => $request->tanggal,
                'metode_bayar'    => $request->metode_bayar,
                'total_pemasukan' => $totalPemasukan,
                'catatan'         => $request->catatan,
            ]);

            $pemasukan->details()->delete();
            $pemasukan->details()->createMany($details->toArray());
        });

        return redirect()->route('pemilik.pemasukan.show', $pemasukan)
            ->with('success', 'Data pemasukan berhasil diperbarui.');
    }

    // Helper 

    private function authorizeRole(): void
    {
        if (! auth()->user()?->hasRole('pemilik_toko')) {
            abort(403, 'Akses Ditolak: Halaman ini hanya untuk Pemilik Toko.');
        }
    }
}