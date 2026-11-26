@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')
    <x-admin-form-styles />

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-ink sm:text-2xl">Edit Pengguna: {{ $user->name }}</h2>
            <p class="mt-1 text-sm text-slate-500">Perbarui profil, hak akses peran, atau setel ulang kata sandi.</p>
        </div>
        <div class="flex items-center gap-3">
            @if ($user->id === auth()->id())
                <span class="rounded-lg border border-brand/20 bg-brand/10 px-3 py-1.5 text-xs font-semibold text-brand">Akun Anda Saat Ini</span>
            @endif
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
    </div>

    <div class="admin-card rounded-2xl border border-line bg-white p-6 shadow-[0_2px_10px_rgba(15,43,92,0.04)] sm:p-7">
        @if (session('error'))
            <div class="mb-6 flex items-start gap-3 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="font-medium">{{ session('error') }}</div>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="mb-2 block text-xs font-semibold text-slate-700">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        class="h-12 w-full rounded-[10px] border bg-white px-4 text-sm text-ink transition focus:outline-none focus:ring-2 @error('name') border-rose-400 focus:border-rose-400 focus:ring-rose-200 @else border-line focus:border-brand focus:ring-brand/20 @enderror"
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
                        value="{{ old('username', $user->username) }}"
                        required
                        class="h-12 w-full rounded-[10px] border bg-white px-4 text-sm text-ink transition focus:outline-none focus:ring-2 @error('username') border-rose-400 focus:border-rose-400 focus:ring-rose-200 @else border-line focus:border-brand focus:ring-brand/20 @enderror"
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
                        value="{{ old('email', $user->email) }}"
                        required
                        class="h-12 w-full rounded-[10px] border bg-white px-4 text-sm text-ink transition focus:outline-none focus:ring-2 @error('email') border-rose-400 focus:border-rose-400 focus:ring-rose-200 @else border-line focus:border-brand focus:ring-brand/20 @enderror"
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
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ $role->name }} ({{ $role->slug }})
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="admin-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-3 block text-xs font-semibold text-slate-700">
                        Status Akun <span class="text-rose-500">*</span>
                    </label>

                    @if ($user->id === auth()->id())
                        <div class="mb-3 rounded-xl border border-amber-200 bg-amber-50 p-3 text-xs text-amber-800">
                            <strong>Catatan Keamanan:</strong> Anda tidak dapat menonaktifkan status akun Anda sendiri agar tidak terkunci keluar dari sistem.
                        </div>
                        <input type="hidden" name="is_active" value="1">
                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            Aktif (Terkunci untuk akun sendiri)
                        </span>
                    @else
                        <div class="flex flex-wrap items-center gap-6">
                            <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-700">
                                <input type="radio" name="is_active" value="1" {{ old('is_active', (string)$user->is_active) === '1' ? 'checked' : '' }} class="h-4 w-4 accent-brand">
                                <span>Aktif (Dapat Login)</span>
                            </label>
                            <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-700">
                                <input type="radio" name="is_active" value="0" {{ old('is_active', (string)$user->is_active) === '0' ? 'checked' : '' }} class="h-4 w-4 accent-rose-500">
                                <span>Nonaktif (Diblokir)</span>
                            </label>
                        </div>
                    @endif

                    @error('is_active')
                        <p class="admin-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-line pt-5 sm:col-span-2">
                    <h3 class="text-sm font-semibold text-ink">Ubah Kata Sandi (Opsional)</h3>
                    <p class="mt-1 text-xs text-slate-400">Kosongkan kedua kolom di bawah jika Anda tidak berniat mengubah kata sandi pengguna ini.</p>
                </div>

                <div>
                    <label for="password" class="mb-2 block text-xs font-semibold text-slate-700">Kata Sandi Baru</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Biarkan kosong jika tidak diubah"
                        class="h-12 w-full rounded-[10px] border bg-white px-4 text-sm text-ink transition placeholder:text-slate-400 focus:outline-none focus:ring-2 @error('password') border-rose-400 focus:border-rose-400 focus:ring-rose-200 @else border-line focus:border-brand focus:ring-brand/20 @enderror"
                    >
                    @error('password')
                        <p class="admin-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-xs font-semibold text-slate-700">Ulangi Kata Sandi Baru</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ketik ulang kata sandi baru"
                        class="h-12 w-full rounded-[10px] border border-line bg-white px-4 text-sm text-ink transition placeholder:text-slate-400 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20"
                    >
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
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
