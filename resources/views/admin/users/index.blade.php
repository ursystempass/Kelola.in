@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
    <x-admin-form-styles />

    <!-- Judul halaman + aksi utama -->
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-ink sm:text-2xl">Manajemen Data Pengguna</h2>
            <p class="mt-1 text-sm text-slate-500">Kelola akun staf, hak akses, dan status operasional sistem Toko Sembako.</p>
        </div>
        <a
            href="{{ route('admin.users.create') }}"
            class="admin-btn admin-btn-primary inline-flex h-11 items-center justify-center gap-2 rounded-[10px] bg-brand px-4 text-sm font-semibold text-white transition hover:bg-brand-dark active:bg-brand-active"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Pengguna Baru</span>
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

    <!-- Filter -->
    <div class="admin-card mb-6 rounded-2xl border border-line bg-white p-5 shadow-[0_2px_10px_rgba(15,43,92,0.04)]">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-12 sm:items-end">
            <div class="sm:col-span-5">
                <label for="search" class="mb-2 block text-xs font-semibold text-slate-700">Cari Pengguna</label>
                <div class="relative">
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama, username, atau email..."
                        class="admin-input-icon h-12 w-full rounded-[10px] border border-line bg-white pl-10 pr-4 text-sm text-ink transition placeholder:text-slate-400 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20"
                    >
                    <svg class="pointer-events-none absolute left-3 top-3.5 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <div class="sm:col-span-3">
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

            <div class="sm:col-span-2">
                <label for="status" class="mb-2 block text-xs font-semibold text-slate-700">Status</label>
                <select
                    id="status"
                    name="status"
                    class="h-12 w-full rounded-[10px] border border-line bg-white px-3 text-sm text-ink transition focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20"
                >
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="flex items-center gap-2 sm:col-span-2">
                <button
                    type="submit"
                    class="admin-btn admin-btn-primary admin-btn-search h-12 flex-1 rounded-[10px] bg-brand px-3 text-sm font-semibold text-white transition hover:bg-brand-dark active:bg-brand-active"
                >
                    Cari
                </button>
                @if(request('search') || request('role') || request('status') !== null && request('status') !== '')
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="admin-btn admin-btn-secondary admin-btn-search inline-flex h-12 items-center justify-center rounded-[10px] border border-line bg-white px-3 text-sm font-medium text-slate-600 transition hover:bg-canvas"
                    >
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel -->
    <div class="admin-card overflow-hidden rounded-2xl border border-line bg-white shadow-[0_2px_10px_rgba(15,43,92,0.04)]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm text-slate-600">
                <thead class="bg-[#F8FAFD] text-[11px] uppercase tracking-wider text-slate-500">
                    <tr class="border-b border-line">
                        <th class="px-4 py-3.5 font-semibold">Pengguna</th>
                        <th class="px-4 py-3.5 font-semibold">Email</th>
                        <th class="px-4 py-3.5 font-semibold">Role</th>
                        <th class="px-4 py-3.5 font-semibold">Status Akun</th>
                        <th class="px-4 py-3.5 text-right font-semibold">Aksi</th>
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
                                <span class="inline-flex items-center rounded-lg border px-2.5 py-1 text-xs font-medium {{ $badgeClass }}">
                                    {{ $user->role?->name ?? 'Belum ada role' }}
                                </span>
                            </td>

                            <td class="px-4 py-3.5">
                                @if ($user->is_active)
                                    <span class="inline-flex items-center gap-1.5 rounded-lg border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Aktif</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1 text-xs font-medium text-rose-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                        <span>Nonaktif</span>
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3.5 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <a
                                        href="{{ route('admin.users.edit', $user) }}"
                                        class="rounded-[10px] p-2 text-slate-500 transition hover:bg-brand/10 hover:text-brand"
                                        title="Edit Data Pengguna"
                                        aria-label="Edit {{ $user->name }}"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    @if ($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                class="rounded-[10px] p-2 text-slate-500 transition hover:bg-brand/10 hover:text-brand"
                                                title="{{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}"
                                                onclick="return confirm('Apakah Anda yakin ingin mengubah status akun {{ $user->name }}?')"
                                            >
                                                @if($user->is_active)
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                    </svg>
                                                @else
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('PERINGATAN: Apakah Anda yakin ingin menghapus akun {{ $user->name }}? Data yang dihapus tidak dapat dipulihkan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="rounded-[10px] p-2 text-rose-500 transition hover:bg-rose-50 hover:text-rose-700"
                                                title="Hapus Pengguna"
                                                aria-label="Hapus {{ $user->name }}"
                                            >
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <span class="px-2 text-[11px] italic text-slate-400">Akun Saya</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <svg class="mx-auto mb-3 h-12 w-12 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p class="font-medium text-slate-600">Tidak ada pengguna yang sesuai dengan kriteria pencarian.</p>
                                <p class="mt-1 text-xs text-slate-400">Coba sesuaikan kata kunci atau reset filter pencarian.</p>
                            </td>
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
