@extends('layouts.admin')

@section('title', 'Hak Akses')

@section('content')
    <x-admin-form-styles />

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-ink sm:text-2xl">Manajemen Hak Akses & Peran Pengguna</h2>
            <p class="mt-1 text-sm text-slate-500">Tetapkan dan ubah wewenang aktor sistem: Admin, Pemilik Toko, atau Karyawan.</p>
        </div>
        <a
            href="{{ route('admin.users.index') }}"
            class="admin-btn admin-btn-primary inline-flex h-11 items-center justify-center gap-2 rounded-[10px] bg-brand px-4 text-sm font-semibold text-white transition hover:bg-brand-dark active:bg-brand-active"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span>Lihat Manajemen User</span>
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 flex items-start gap-3 rounded-xl border border-brand/20 bg-brand/10 p-4 text-sm text-ink">
            <svg class="mt-0.5 h-5 w-5 shrink-0 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="font-medium">{{ session('success') }}</div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 flex items-start gap-3 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
            <svg class="mt-0.5 h-5 w-5 shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="font-medium">{{ session('error') }}</div>
        </div>
    @endif

    <!-- Kartu Ikhtisar Role -->
    <div class="mb-6 grid grid-cols-1 gap-5 md:grid-cols-3">
        @foreach ($roles as $r)
            @php
                $style = match($r->slug) {
                    'admin' => ['border' => 'border-brand/20', 'bg' => 'bg-brand/[0.03]', 'pill' => 'bg-brand/10 text-brand'],
                    'pemilik_toko' => ['border' => 'border-line', 'bg' => 'bg-canvas', 'pill' => 'bg-slate-100 text-slate-700'],
                    'karyawan' => ['border' => 'border-amber-200', 'bg' => 'bg-amber-50/60', 'pill' => 'bg-amber-100 text-amber-700'],
                    default => ['border' => 'border-line', 'bg' => 'bg-canvas', 'pill' => 'bg-slate-100 text-slate-700']
                };
            @endphp
            <div class="rounded-2xl border {{ $style['border'] }} {{ $style['bg'] }} p-5 shadow-[0_2px_10px_rgba(15,43,92,0.04)]">
                <div class="mb-3 flex items-center justify-between gap-3">
                    <span class="rounded-md px-2.5 py-0.5 text-[11px] font-semibold {{ $style['pill'] }}">{{ $r->slug }}</span>
                    <span class="text-xs text-slate-500">{{ $r->permissions->count() }} Izin Fitur</span>
                </div>
                <h3 class="text-base font-semibold text-ink">{{ $r->name }}</h3>
                <div class="mt-3 flex flex-wrap gap-1.5">
                    @foreach ($r->permissions->take(4) as $p)
                        <span class="rounded-md bg-white px-2 py-0.5 text-[11px] font-medium text-slate-600">{{ $p->name }}</span>
                    @endforeach
                    @if ($r->permissions->count() > 4)
                        <span class="rounded-md bg-white px-1.5 py-0.5 text-[11px] font-semibold text-slate-500">
                            +{{ $r->permissions->count() - 4 }} lainnya
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Filter -->
    <div class="admin-card mb-6 rounded-2xl border border-line bg-white p-5 shadow-[0_2px_10px_rgba(15,43,92,0.04)]">
        <form method="GET" action="{{ route('admin.hak-akses.index') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-12 sm:items-end">
            <div class="sm:col-span-6">
                <label for="search" class="mb-2 block text-xs font-semibold text-slate-700">Cari Pengguna</label>
                <div class="relative">
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari pengguna berdasarkan nama, username, atau email..."
                        class="admin-input-icon h-12 w-full rounded-[10px] border border-line bg-white pl-10 pr-4 text-sm text-ink transition placeholder:text-slate-400 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20"
                    >
                    <svg class="pointer-events-none absolute left-3 top-3.5 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <div class="sm:col-span-4">
                <label for="role" class="mb-2 block text-xs font-semibold text-slate-700">Peran (Role)</label>
                <select
                    id="role"
                    name="role"
                    class="h-12 w-full rounded-[10px] border border-line bg-white px-3 text-sm text-ink transition focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20"
                >
                    <option value="">Semua Peran (Role)</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->slug }}" {{ request('role') === $role->slug ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2 sm:col-span-2">
                <button
                    type="submit"
                    class="admin-btn admin-btn-primary admin-btn-search h-12 flex-1 rounded-[10px] bg-brand px-3 text-sm font-semibold text-white transition hover:bg-brand-dark active:bg-brand-active"
                >
                    Cari
                </button>
                @if(request('search') || request('role'))
                    <a
                        href="{{ route('admin.hak-akses.index') }}"
                        class="admin-btn admin-btn-secondary admin-btn-search inline-flex h-12 items-center justify-center rounded-[10px] border border-line bg-white px-3 text-sm font-medium text-slate-600 transition hover:bg-canvas"
                    >
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Otorisasi -->
    <div class="admin-card overflow-hidden rounded-2xl border border-line bg-white shadow-[0_2px_10px_rgba(15,43,92,0.04)]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px] text-left text-sm text-slate-600">
                <thead class="bg-[#F8FAFD] text-[11px] uppercase tracking-wider text-slate-500">
                    <tr class="border-b border-line">
                        <th class="px-4 py-3.5 font-semibold">Pengguna</th>
                        <th class="px-4 py-3.5 font-semibold">Email</th>
                        <th class="px-4 py-3.5 font-semibold">Peran Saat Ini</th>
                        <th class="px-4 py-3.5 font-semibold">Cakupan Hak Akses</th>
                        <th class="px-4 py-3.5 text-right font-semibold">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse ($users as $user)
                        <tr class="transition hover:bg-canvas {{ $user->id === auth()->id() ? 'bg-brand/[0.02]' : '' }}">
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] border border-line bg-canvas text-xs font-semibold uppercase text-slate-700">
                                        {{ substr($user->name, 0, 2) }}
                                    </span>
                                    <span class="min-w-0">
                                        <span class="flex items-center gap-1.5 font-semibold text-ink">
                                            <span class="truncate">{{ $user->name }}</span>
                                            @if ($user->id === auth()->id())
                                                <span class="rounded-md bg-brand/10 px-1.5 py-0.5 text-[10px] font-semibold text-brand">Anda</span>
                                            @endif
                                        </span>
                                        <span class="block text-xs text-slate-400">@{{ $user->username }}</span>
                                    </span>
                                </div>
                            </td>

                            <td class="px-4 py-3.5 text-xs text-slate-600">{{ $user->email }}</td>

                            <td class="px-4 py-3.5">
                                @php
                                    $roleSlug = $user->role?->slug;
                                    $badgeClass = match($roleSlug) {
                                        'admin' => 'bg-brand/10 text-brand border-brand/20',
                                        'pemilik_toko' => 'bg-slate-100 text-slate-700 border-line',
                                        'karyawan' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        default => 'bg-canvas text-slate-600 border-line'
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-lg border px-3 py-1 text-xs font-semibold {{ $badgeClass }}">
                                    {{ $user->role?->name ?? 'Belum ada role' }}
                                </span>
                            </td>

                            <td class="px-4 py-3.5 text-xs text-slate-500">
                                @if ($user->role)
                                    <span class="font-medium text-slate-700">{{ $user->role->permissions->count() }} Hak Akses Terpasang</span>
                                    <span class="block truncate text-[11px] text-slate-400">{{ $user->role->permissions->pluck('name')->implode(', ') }}</span>
                                @else
                                    <span class="italic text-rose-500">Tidak memiliki hak akses</span>
                                @endif
                            </td>

                            <td class="px-4 py-3.5 text-right">
                                @if ($user->id !== auth()->id())
                                    <a
                                        href="{{ route('admin.hak-akses.edit', $user) }}"
                                        class="inline-flex items-center gap-1.5 rounded-[10px] border border-brand/20 bg-brand/10 px-3 py-1.5 text-xs font-semibold text-brand transition hover:bg-brand/20"
                                    >
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                        <span>Ubah Peran</span>
                                    </a>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-md bg-canvas px-2 py-1 text-[11px] italic text-slate-400">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Akun Sendiri (Terkunci)
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-400">Tidak ada data pengguna ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="flex items-center justify-end border-t border-line bg-canvas px-4 py-3">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
