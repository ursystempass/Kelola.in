<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKategoriSatuanRequest;
use App\Http\Requests\UpdateKategoriSatuanRequest;
use App\Models\KategoriSatuan;
use Illuminate\Http\Request;

class KategoriSatuanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $satuans = KategoriSatuan::withCount('barangs')
            ->when($search, function ($query, $search) {
                $query->where('nama_satuan', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->orderBy('nama_satuan', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kategori-satuan.index', compact('satuans', 'search'));
    }

    public function create()
    {
        return view('admin.kategori-satuan.create');
    }

    public function store(StoreKategoriSatuanRequest $request)
    {
        KategoriSatuan::create($request->validated());

        return redirect()
            ->route('admin.kategori-satuan.index')
            ->with('success', 'Kategori satuan berhasil ditambahkan.');
    }

    public function edit(KategoriSatuan $kategoriSatuan)
    {
        return view('admin.kategori-satuan.edit', compact('kategoriSatuan'));
    }

    public function update(UpdateKategoriSatuanRequest $request, KategoriSatuan $kategoriSatuan)
    {
        $kategoriSatuan->update($request->validated());

        return redirect()
            ->route('admin.kategori-satuan.index')
            ->with('success', 'Kategori satuan berhasil diperbarui.');
    }

    public function destroy(KategoriSatuan $kategoriSatuan)
    {
        if ($kategoriSatuan->barangs()->exists()) {
            return redirect()
                ->route('admin.kategori-satuan.index')
                ->with('error', "Satuan \"{$kategoriSatuan->nama_satuan}\" tidak dapat dihapus karena masih digunakan oleh data barang.");
        }

        $kategoriSatuan->delete();

        return redirect()
            ->route('admin.kategori-satuan.index')
            ->with('success', 'Kategori satuan berhasil dihapus.');
    }
}