@extends('layouts.admin')

@section('title', 'Ubah Hak Akses Pengguna')

@section('content')
    <x-admin-form-styles />

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-ink sm:text-2xl">Ubah Hak Akses Pengguna</h2>
            <p class="mt-1 text-sm text-slate-500">Peran menentukan menu, halaman, dan fitur yang dapat diakses oleh akun ini.</p>
        </div>
        <a
            href="{{ route('admin.hak-akses.index') }}"
            class="admin-btn admin-btn-secondary inline-flex h-11 items-center justify-center gap-2 rounded-[10px] border border-line bg-white px-4 text-sm font-medium text-slate-600 transition hover:bg-canvas hover:text-ink"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Batal & Kembali</span>
        </a>
    </div>

    <!-- Profil pengguna sasaran -->
    <div class="admin-card mb-6 flex flex-col gap-4 rounded-2xl border border-line bg-white p-6 shadow-[0_2px_10px_rgba(15,43,92,0.04)] sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-brand/20 bg-brand/10 text-lg font-semibold uppercase text-brand">
                {{ substr($user->name, 0, 2) }}
            </span>
            <span class="min-w-0">
                <span class="block text-[10px] font-semibold uppercase tracking-wider text-slate-400">Pengguna yang Diubah</span>
                <span class="block text-lg font-semibold text-ink">{{ $user->name }}</span>
                <span class="block text-xs text-slate-500">Username: <span class="text-slate-700">@{{ $user->username }}</span> • Email: <span class="text-slate-700">{{ $user->email }}</span></span>
            </span>
        </div>

        <div class="sm:text-right">
            <span class="mb-1 block text-xs text-slate-400">Peran Saat Ini:</span>
            <span class="inline-flex items-center rounded-lg border border-line bg-canvas px-3 py-1 text-xs font-semibold text-ink">
                {{ $user->role?->name ?? 'Belum ada peran' }}
            </span>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
            @foreach ($errors->all() as $err)
                <p class="font-medium">• {{ $err }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.hak-akses.update', $user) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="admin-card rounded-2xl border border-line bg-white p-6 shadow-[0_2px_10px_rgba(15,43,92,0.04)]">
            <div class="mb-5">
                <h3 class="text-base font-semibold text-ink">Pilih Peran Baru untuk Pengguna</h3>
                <p class="mt-1 text-xs text-slate-500">Peran menentukan menu, halaman, dan fitur yang dapat diakses oleh akun ini pada sistem Toko Sembako.</p>
            </div>

            <div class="grid grid-cols-1 gap-4">
                @foreach ($roles as $roleOption)
                    @php
                        $isSelected = (old('role_id', $user->role_id) == $roleOption->id);
                        $accentColor = match($roleOption->slug) {
                            'admin' => 'peer-checked:border-brand peer-checked:bg-brand/5',
                            'pemilik_toko' => 'peer-checked:border-brand peer-checked:bg-brand/5',
                            'karyawan' => 'peer-checked:border-amber-500 peer-checked:bg-amber-50/60',
                            default => 'peer-checked:border-slate-500 peer-checked:bg-canvas'
                        };
                    @endphp
                    <label class="relative flex cursor-pointer items-start gap-4 rounded-2xl border-2 border-line p-5 transition hover:border-brand/40 {{ $accentColor }}">
                        <input
                            type="radio"
                            name="role_id"
                            value="{{ $roleOption->id }}"
                            {{ $isSelected ? 'checked' : '' }}
                            class="peer sr-only"
                        >
                        <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full border-2 border-slate-300 transition peer-checked:border-brand peer-checked:bg-brand">
                            <span class="h-2 w-2 rounded-full bg-white"></span>
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="mb-1 flex flex-wrap items-center justify-between gap-2">
                                <span class="text-sm font-semibold text-ink">{{ $roleOption->name }}</span>
                                <span class="rounded-md bg-canvas px-2 py-0.5 font-mono text-xs text-slate-500">slug: {{ $roleOption->slug }}</span>
                            </span>
                            <span class="mb-3 block text-xs text-slate-500">
                                @if($roleOption->slug === 'admin')
                                    Wewenang penuh pengelolaan data akun pengguna, role & permission, master barang, RORIS, dan seluruh sistem.
                                @elseif($roleOption->slug === 'pemilik_toko')
                                    Akses monitoring bisnis: Dashboard omset toko, laporan pemasukan harian, stok sembako, dan laporan RORIS.
                                @elseif($roleOption->slug === 'karyawan')
                                    Akses operasional toko harian: Input transaksi kasir, cek stok sembako, dan pencatatan barang masuk (restock).
                                @endif
                            </span>

                            <span class="flex flex-wrap gap-1.5 border-t border-line pt-2">
                                @foreach ($roleOption->permissions as $perm)
                                    <span class="rounded-md bg-canvas px-2 py-0.5 text-[11px] font-medium text-slate-600">✓ {{ $perm->name }}</span>
                                @endforeach
                            </span>
                        </span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-between gap-3">
            <a
                href="{{ route('admin.hak-akses.index') }}"
                class="admin-btn admin-btn-secondary inline-flex h-11 items-center justify-center rounded-[10px] border border-line bg-white px-5 text-sm font-medium text-slate-600 transition hover:bg-canvas"
            >
                Batal
            </a>
            <button
                type="submit"
                class="admin-btn admin-btn-primary inline-flex h-11 items-center justify-center gap-2 rounded-[10px] bg-brand px-6 text-sm font-semibold text-white transition hover:bg-brand-dark active:bg-brand-active"
                onclick="return confirm('Apakah Anda yakin ingin memperbarui hak akses pengguna {{ $user->name }}?')"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Simpan Perubahan Hak Akses</span>
            </button>
        </div>
    </form>
@endsection
