<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\Barang;
use App\Models\KategoriSatuan;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategoriId = $request->input('kategori_satuan_id');
        $statusStok = $request->input('status_stok');

        $satuans = KategoriSatuan::orderBy('nama_satuan', 'asc')->get();

        $barangs = Barang::with('kategoriSatuan')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode_barang', 'like', "%{$search}%")
                      ->orWhere('nama_barang', 'like', "%{$search}%");
                });
            })
            ->when($kategoriId, function ($query, $kategoriId) {
                $query->where('kategori_satuan_id', $kategoriId);
            })
            ->when($statusStok === 'menipis', function ($query) {
                $query->stokMenipis();
            })
            ->when($statusStok === 'aman', function ($query) {
                $query->whereColumn('stok', '>', 'stok_minimum');
            })
            ->orderBy('nama_barang', 'asc')
            ->paginate(10)
            ->withQueryString();

        $totalBarang = Barang::count();
        $totalStokMenipis = Barang::stokMenipis()->count();
        $totalStokAman = max(0, $totalBarang - $totalStokMenipis);

        return view('barang.index', compact(
            'barangs',
            'satuans',
            'search',
            'kategoriId',
            'statusStok',
            'totalBarang',
            'totalStokMenipis',
            'totalStokAman'
        ));
    }

    public function create()
    {
        $satuans = KategoriSatuan::orderBy('nama_satuan', 'asc')->get();
        $lastId = (Barang::withTrashed()->max('id') ?? 0) + 1;
        $suggestedKode = 'BRG-' . str_pad((string) $lastId, 3, '0', STR_PAD_LEFT);

        return view('barang.create', compact('satuans', 'suggestedKode'));
    }

    public function store(StoreBarangRequest $request)
    {
        Barang::create($request->validated());

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        $satuans = KategoriSatuan::orderBy('nama_satuan', 'asc')->get();

        return view('barang.edit', compact('barang', 'satuans'));
    }

    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        $barang->update($request->validated());

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}