@extends('layouts.admin')

@section('title', 'Tambah Pengguna Baru')

@section('content')
    <x-admin-form-styles />

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-ink sm:text-2xl">Tambah Pengguna Baru</h2>
            <p class="mt-1 text-sm text-slate-500">Daftarkan akun staf baru untuk operasional toko sembako.</p>
        </div>
        <a
            href="{{ route('admin.users.index') }}"
            class="admin-btn admin-btn-secondary inline-flex h-11 items-center justify-center gap-2 rounded-[10px] border border-line bg-white px-4 text-sm font-medium text-slate-600 transition hover:bg-canvas hover:text-ink"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <div class="admin-card rounded-2xl border border-line bg-white p-6 shadow-[0_2px_10px_rgba(15,43,92,0.04)] sm:p-7">
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="mb-2 block text-xs font-semibold text-slate-700">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        placeholder="Contoh: Budi Santoso"
                        class="h-12 w-full rounded-[10px] border bg-white px-4 text-sm text-ink transition placeholder:text-slate-400 focus:outline-none focus:ring-2 @error('name') border-rose-400 focus:border-rose-400 focus:ring-rose-200 @else border-line focus:border-brand focus:ring-brand/20 @enderror"
                    >
                    @error('name')
                        <p class="admin-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="username" class="mb-2 block text-xs font-semibold text-slate-700">
                        Username <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        required
                        placeholder="Contoh: budi_kasir"
                        class="h-12 w-full rounded-[10px] border bg-white px-4 text-sm text-ink transition placeholder:text-slate-400 focus:outline-none focus:ring-2 @error('username') border-rose-400 focus:border-rose-400 focus:ring-rose-200 @else border-line focus:border-brand focus:ring-brand/20 @enderror"
                    >
                    @error('username')
                        <p class="admin-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="mb-2 block text-xs font-semibold text-slate-700">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        placeholder="budi@kelolain.com"
                        class="h-12 w-full rounded-[10px] border bg-white px-4 text-sm text-ink transition placeholder:text-slate-400 focus:outline-none focus:ring-2 @error('email') border-rose-400 focus:border-rose-400 focus:ring-rose-200 @else border-line focus:border-brand focus:ring-brand/20 @enderror"
                    >
                    @error('email')
                        <p class="admin-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role_id" class="mb-2 block text-xs font-semibold text-slate-700">
                        Peran (Role) <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="role_id"
                        name="role_id"
                        required
                        class="h-12 w-full rounded-[10px] border bg-white px-4 text-sm text-ink transition focus:outline-none focus:ring-2 @error('role_id') border-rose-400 focus:border-rose-400 focus:ring-rose-200 @else border-line focus:border-brand focus:ring-brand/20 @enderror"
                    >
                        <option value="">-- Pilih Peran Akun --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }} ({{ $role->slug }})
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="admin-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block text-xs font-semibold text-slate-700">
                        Kata Sandi Awal <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        placeholder="Minimal 6 karakter"
                        class="h-12 w-full rounded-[10px] border bg-white px-4 text-sm text-ink transition placeholder:text-slate-400 focus:outline-none focus:ring-2 @error('password') border-rose-400 focus:border-rose-400 focus:ring-rose-200 @else border-line focus:border-brand focus:ring-brand/20 @enderror"
                    >
                    @error('password')
                        <p class="admin-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-xs font-semibold text-slate-700">
                        Ulangi Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        placeholder="Masukkan kata sandi yang sama"
                        class="h-12 w-full rounded-[10px] border border-line bg-white px-4 text-sm text-ink transition placeholder:text-slate-400 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20"
                    >
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-3 block text-xs font-semibold text-slate-700">
                        Status Akun Awal <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex flex-wrap items-center gap-6">
                        <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-700">
                            <input type="radio" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }} class="h-4 w-4 accent-brand">
                            <span>Aktif (Dapat Login)</span>
                        </label>
                        <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-700">
                            <input type="radio" name="is_active" value="0" {{ old('is_active') == '0' ? 'checked' : '' }} class="h-4 w-4 accent-rose-500">
                            <span>Nonaktif (Diblokir)</span>
                        </label>
                    </div>
                    @error('is_active')
                        <p class="admin-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-line pt-6">
                <a
                    href="{{ route('admin.users.index') }}"
                    class="admin-btn admin-btn-secondary inline-flex h-11 items-center justify-center rounded-[10px] border border-line bg-white px-5 text-sm font-medium text-slate-600 transition hover:bg-canvas"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    class="admin-btn admin-btn-primary inline-flex h-11 items-center justify-center rounded-[10px] bg-brand px-5 text-sm font-semibold text-white transition hover:bg-brand-dark active:bg-brand-active"
                >
                    Simpan Pengguna Baru
                </button>
            </div>
        </form>
    </div>
@endsection
