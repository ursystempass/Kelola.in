@extends('layouts.admin')

@section('content')

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Kelola Data Barang</h1>
                <p class="text-sm text-slate-500 mt-1">Manajemen inventaris barang, harga jual, dan pemantauan stok sembako.</p>
            </div>
            <a href="{{ route('barang.create') }}"
               class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl shadow-sm transition">
                <span>+ Tambah Barang</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                <p class="text-xs font-medium uppercase tracking-wider text-slate-500">Total Jenis Barang</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $totalBarang }}</p>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-emerald-200 shadow-sm">
                <p class="text-xs font-medium uppercase tracking-wider text-emerald-600">Stok Aman</p>
                <p class="text-2xl font-bold text-emerald-700 mt-1">{{ $totalStokAman }}</p>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-rose-200 shadow-sm">
                <p class="text-xs font-medium uppercase tracking-wider text-rose-600">Stok Menipis</p>
                <p class="text-2xl font-bold text-rose-700 mt-1">{{ $totalStokMenipis }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 border-b border-slate-100">
                <form method="GET" action="{{ route('barang.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Cari kode atau nama barang..."
                           class="rounded-xl border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">

                    <select name="kategori_satuan_id"
                            class="rounded-xl border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Semua Satuan</option>
                        @foreach($satuans as $satuan)
                            <option value="{{ $satuan->id }}" {{ (string) $kategoriId === (string) $satuan->id ? 'selected' : '' }}>
                                {{ $satuan->nama_satuan }}
                            </option>
                        @endforeach
                    </select>

                    <select name="status_stok"
                            class="rounded-xl border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Semua Status Stok</option>
                        <option value="aman" {{ $statusStok === 'aman' ? 'selected' : '' }}>Stok Aman</option>
                        <option value="menipis" {{ $statusStok === 'menipis' ? 'selected' : '' }}>Stok Menipis</option>
                    </select>

                    <div class="flex gap-2">
                        <button type="submit"
                                class="flex-1 px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-xl transition">
                            Filter
                        </button>
                        @if($search || $kategoriId || $statusStok)
                            <a href="{{ route('barang.index') }}"
                               class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-xl transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            <th class="py-3.5 px-4">Kode</th>
                            <th class="py-3.5 px-4">Nama Barang</th>
                            <th class="py-3.5 px-4">Satuan</th>
                            <th class="py-3.5 px-4 text-right">Harga Beli</th>
                            <th class="py-3.5 px-4 text-right">Harga Jual</th>
                            <th class="py-3.5 px-4 text-center">Stok</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($barangs as $barang)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3.5 px-4 font-mono text-xs font-semibold text-slate-600">{{ $barang->kode_barang }}</td>
                                <td class="py-3.5 px-4 font-semibold text-slate-800">{{ $barang->nama_barang }}</td>
                                <td class="py-3.5 px-4 text-slate-600">{{ $barang->kategoriSatuan->nama_satuan ?? '-' }}</td>
                                <td class="py-3.5 px-4 text-right text-slate-600">Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-4 text-right font-medium text-slate-800">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-4 text-center font-semibold">
                                    {{ $barang->stok }} <span class="text-xs font-normal text-slate-400">/ min {{ $barang->stok_minimum }}</span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    @if($barang->isStokMenipis())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-700">
                                            Menipis
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                            Aman
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('barang.edit', $barang) }}"
                                           class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-medium rounded-lg transition">
                                            Ubah
                                        </a>
                                        <form method="POST" action="{{ route('barang.destroy', $barang) }}"
                                              onsubmit="return confirm('Yakin ingin menghapus barang {{ $barang->nama_barang }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-medium rounded-lg transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 px-4 text-center text-slate-400">
                                    Data barang tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($barangs->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $barangs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection