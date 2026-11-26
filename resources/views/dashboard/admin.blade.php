@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Kartu Sambutan Ringkas -->
    <div class="rounded-2xl border border-line bg-white p-6 shadow-[0_2px_10px_rgba(15,43,92,0.04)] sm:p-7">
        <div class="flex items-center justify-between gap-6">
            <div class="min-w-0">
                <h2 class="truncate text-2xl font-bold tracking-tight text-ink">
                    Halo, {{ auth()->user()->name }}! 👋
                </h2>
                <p class="mt-2 text-sm text-slate-500">Selamat datang kembali di Kelola.in</p>
            </div>

            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand/10 text-brand">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Tiga Kartu Statistik -->
    <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="flex h-full items-center gap-4 rounded-2xl border border-line bg-white p-6 shadow-[0_2px_10px_rgba(15,43,92,0.04)] transition hover:shadow-[0_6px_18px_rgba(15,43,92,0.06)]">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand/10 text-brand">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Total User</p>
                <p class="mt-1 text-2xl font-bold tracking-tight text-ink">{{ $totalUsers }}</p>
            </div>
        </div>

        <div class="flex h-full items-center gap-4 rounded-2xl border border-line bg-white p-6 shadow-[0_2px_10px_rgba(15,43,92,0.04)] transition hover:shadow-[0_6px_18px_rgba(15,43,92,0.06)]">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand/10 text-brand">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Akun Aktif</p>
                <p class="mt-1 text-2xl font-bold tracking-tight text-ink">{{ $activeUsers }}</p>
            </div>
        </div>

        <div class="flex h-full items-center gap-4 rounded-2xl border border-line bg-white p-6 shadow-[0_2px_10px_rgba(15,43,92,0.04)] transition hover:shadow-[0_6px_18px_rgba(15,43,92,0.06)]">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Akun Nonaktif</p>
                <p class="mt-1 text-2xl font-bold tracking-tight text-ink">{{ $inactiveUsers }}</p>
            </div>
        </div>
    </div>

    <!-- Dua Panel Bawah -->
    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="flex h-full flex-col justify-between rounded-2xl border border-line bg-white p-6 shadow-[0_2px_10px_rgba(15,43,92,0.04)]">
            <div>
                <div class="mb-5 flex items-center justify-between gap-3">
                    <h3 class="text-base font-semibold text-ink">Ringkasan Sistem</h3>
                    <span class="text-xs text-slate-400">Berdasarkan Peran</span>
                </div>

                <div class="divide-y divide-line">
                    <div class="flex items-center justify-between gap-3 py-3.5">
                        <div class="flex items-center gap-3">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand/10 text-brand">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </span>
                            <span class="text-sm text-slate-700">Administrator</span>
                        </div>
                        <span class="text-sm font-semibold text-ink">{{ $roleCounts['admin'] ?? 0 }} Orang</span>
                    </div>

                    <div class="flex items-center justify-between gap-3 py-3.5">
                        <div class="flex items-center gap-3">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-100 text-slate-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </span>
                            <span class="text-sm text-slate-700">Pemilik Toko</span>
                        </div>
                        <span class="text-sm font-semibold text-ink">{{ $roleCounts['pemilik_toko'] ?? 0 }} Orang</span>
                    </div>

                    <div class="flex items-center justify-between gap-3 py-3.5">
                        <div class="flex items-center gap-3">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-50 text-amber-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <span class="text-sm text-slate-700">Karyawan</span>
                        </div>
                        <span class="text-sm font-semibold text-ink">{{ $roleCounts['karyawan'] ?? 0 }} Orang</span>
                    </div>
                </div>
            </div>

            <div class="mt-2 border-t border-line pt-4">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand transition hover:text-brand-dark">
                    <span>Lihat kelola pengguna selengkapnya</span>
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="flex h-full flex-col justify-between rounded-2xl border border-line bg-white p-6 shadow-[0_2px_10px_rgba(15,43,92,0.04)]">
            <div>
                <div class="mb-5 flex items-center justify-between gap-3">
                    <h3 class="text-base font-semibold text-ink">Aktivitas Terbaru</h3>
                    <span class="text-xs text-slate-400">Pengguna Terdaftar</span>
                </div>

                <div class="divide-y divide-line">
                    @forelse ($recentUsers as $userItem)
                        @php
                            $roleColors = match ($userItem->role?->slug) {
                                'admin' => ['bg' => 'bg-brand/10', 'text' => 'text-brand'],
                                'pemilik_toko' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600'],
                                'karyawan' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600'],
                                default => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600'],
                            };
                        @endphp
                        <div class="flex items-center justify-between gap-3 py-3">
                            <div class="flex min-w-0 items-center gap-3">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full {{ $roleColors['bg'] }} {{ $roleColors['text'] }}">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </span>
                                <span class="min-w-0">
                                    <span class="block truncate text-sm font-medium text-slate-800">User baru: {{ $userItem->name }}</span>
                                    <span class="block truncate text-xs text-slate-400">{{ $userItem->role?->name ?? 'Belum ada peran' }}</span>
                                </span>
                            </div>
                            <span class="shrink-0 text-xs text-slate-400">
                                {{ $userItem->created_at ? $userItem->created_at->locale('id')->diffForHumans() : 'Baru saja' }}
                            </span>
                        </div>
                    @empty
                        <div class="py-8 text-center text-sm text-slate-400">Belum ada aktivitas</div>
                    @endforelse
                </div>
            </div>

            <div class="mt-2 border-t border-line pt-4">
                <a href="{{ route('admin.hak-akses.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand transition hover:text-brand-dark">
                    <span>Atur peran & hak akses akun</span>
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
@endsection
