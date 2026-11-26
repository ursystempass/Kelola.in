@extends('layouts.admin')

@section('content')
    <x-admin-form-styles />

    <div class="space-y-6">
        <div>
            <a href="{{ route('admin.kategori-satuan.index') }}" class="admin-link">&larr; Kembali ke Daftar Satuan</a>
            <h2 class="mt-2 text-2xl font-bold tracking-tight text-ink">Tambah Kategori Satuan</h2>
            <p class="mt-1 text-sm text-slate-500">Tambahkan satuan baru yang digunakan untuk data barang sembako.</p>
        </div>

        <div class="admin-card max-w-[720px] p-7 sm:p-8">
            <form method="POST" action="{{ route('admin.kategori-satuan.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="nama_satuan" class="mb-2 block">Nama Satuan <span class="text-rose-500">*</span></label>
                    <input
                        type="text"
                        id="nama_satuan"
                        name="nama_satuan"
                        value="{{ old('nama_satuan') }}"
                        placeholder="Contoh: Kg, Liter, Pcs, Dus, Karung"
                        class="@error('nama_satuan') is-invalid @enderror"
                        autofocus
                        required
                    >
                    @error('nama_satuan')
                        <p class="admin-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="deskripsi" class="mb-2 block">Deskripsi <span class="admin-optional">(Opsional)</span></label>
                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        rows="3"
                        placeholder="Keterangan singkat penggunaan satuan..."
                        class="@error('deskripsi') is-invalid @enderror"
                    >{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="admin-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex flex-col-reverse gap-3 border-t border-line pt-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.kategori-satuan.index') }}" class="admin-btn admin-btn-secondary w-full sm:w-auto">Batal</a>
                    <button type="submit" class="admin-btn admin-btn-primary w-full sm:w-auto">Simpan Satuan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
