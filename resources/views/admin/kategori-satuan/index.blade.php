@extends('layouts.admin')

@section('content')
    <x-admin-form-styles />

    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-ink">Kelola Kategori Satuan</h2>
                <p class="mt-1 text-sm text-slate-500">Daftar satuan unit barang sembako yang digunakan pada sistem.</p>
            </div>
            <a href="{{ route('admin.kategori-satuan.create') }}" class="admin-btn admin-btn-primary">
                <span>+ Tambah Satuan</span>
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="admin-card overflow-hidden">
            <div class="border-b border-line p-5">
                <form method="GET" action="{{ route('admin.kategori-satuan.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <div class="relative w-full sm:w-[400px]">
                        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Cari nama satuan atau deskripsi..."
                            class="admin-input-icon"
                        >
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="admin-btn admin-btn-primary admin-btn-search">Cari</button>
                        @if ($search)
                            <a href="{{ route('admin.kategori-satuan.index') }}" class="admin-btn admin-btn-secondary admin-btn-search">Reset</a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="admin-table min-w-[680px] text-left">
                    <thead>
                        <tr>
                            <th class="w-16">No</th>
                            <th>Nama Satuan</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Jumlah Barang</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($satuans as $index => $satuan)
                            <tr>
                                <td><span class="text-slate-500">{{ $satuans->firstItem() + $index }}</span></td>
                                <td><span class="font-semibold text-ink">{{ $satuan->nama_satuan }}</span></td>
                                <td><span class="text-slate-600">{{ $satuan->deskripsi ?? '-' }}</span></td>
                                <td class="text-center">
                                    <span class="inline-flex items-center rounded-full bg-brand/10 px-2.5 py-0.5 text-xs font-medium text-brand">
                                        {{ $satuan->barangs_count }} barang
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('admin.kategori-satuan.edit', $satuan) }}"
                                           class="admin-btn admin-btn-icon admin-btn-primary"
                                           title="Ubah {{ $satuan->nama_satuan }}"
                                           aria-label="Ubah {{ $satuan->nama_satuan }}">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.kategori-satuan.destroy', $satuan) }}"
                                              class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus satuan {{ $satuan->nama_satuan }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-btn admin-btn-icon admin-btn-danger"
                                                    title="Hapus {{ $satuan->nama_satuan }}"
                                                    aria-label="Hapus {{ $satuan->nama_satuan }}">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="admin-empty">
                                    <svg class="mx-auto mb-3 h-10 w-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    <p class="text-sm">Belum ada data kategori satuan.</p>
                                    <a href="{{ route('admin.kategori-satuan.create') }}" class="admin-btn admin-btn-primary mt-4">+ Tambah Satuan</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($satuans->hasPages())
                <div class="flex justify-end border-t border-line px-5 py-3">
                    {{ $satuans->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
