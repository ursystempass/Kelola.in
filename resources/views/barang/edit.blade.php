@extends('layouts.admin')

@section('content')

    <div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8 space-y-6">
        <div>
            <a href="{{ route('barang.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Kembali ke Daftar Barang</a>
            <h1 class="text-2xl font-bold text-slate-800 mt-2">Ubah Data Barang</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <form method="POST" action="{{ route('barang.update', $barang) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="kode_barang" class="block text-sm font-medium text-slate-700 mb-1">Kode Barang <span class="text-rose-500">*</span></label>
                        <input type="text" id="kode_barang" name="kode_barang"
                               value="{{ old('kode_barang', $barang->kode_barang) }}"
                               class="w-full rounded-xl border-slate-300 text-sm uppercase focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('kode_barang')
                            <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kategori_satuan_id" class="block text-sm font-medium text-slate-700 mb-1">Kategori Satuan <span class="text-rose-500">*</span></label>
                        <select id="kategori_satuan_id" name="kategori_satuan_id"
                                class="w-full rounded-xl border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @foreach($satuans as $satuan)
                                <option value="{{ $satuan->id }}" {{ old('kategori_satuan_id', $barang->kategori_satuan_id) == $satuan->id ? 'selected' : '' }}>
                                    {{ $satuan->nama_satuan }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_satuan_id')
                            <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="nama_barang" class="block text-sm font-medium text-slate-700 mb-1">Nama Barang <span class="text-rose-500">*</span></label>
                    <input type="text" id="nama_barang" name="nama_barang"
                           value="{{ old('nama_barang', $barang->nama_barang) }}"
                           class="w-full rounded-xl border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('nama_barang')
                        <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="harga_beli" class="block text-sm font-medium text-slate-700 mb-1">Harga Beli (Rp) <span class="text-rose-500">*</span></label>
                        <input type="number" id="harga_beli" name="harga_beli" min="0"
                               value="{{ old('harga_beli', $barang->harga_beli) }}"
                               class="w-full rounded-xl border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('harga_beli')
                            <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="harga_jual" class="block text-sm font-medium text-slate-700 mb-1">Harga Jual (Rp) <span class="text-rose-500">*</span></label>
                        <input type="number" id="harga_jual" name="harga_jual" min="0"
                               value="{{ old('harga_jual', $barang->harga_jual) }}"
                               class="w-full rounded-xl border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('harga_jual')
                            <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="stok" class="block text-sm font-medium text-slate-700 mb-1">Stok Saat Ini <span class="text-rose-500">*</span></label>
                        <input type="number" id="stok" name="stok" min="0"
                               value="{{ old('stok', $barang->stok) }}"
                               class="w-full rounded-xl border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('stok')
                            <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stok_minimum" class="block text-sm font-medium text-slate-700 mb-1">Batas Stok Minimum <span class="text-rose-500">*</span></label>
                        <input type="number" id="stok_minimum" name="stok_minimum" min="0"
                               value="{{ old('stok_minimum', $barang->stok_minimum) }}"
                               class="w-full rounded-xl border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('stok_minimum')
                            <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('barang.index') }}"
                       class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl shadow-sm transition">
                        Perbarui Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection