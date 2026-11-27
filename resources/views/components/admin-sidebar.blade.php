@php
    $roleSlug = auth()->user()->role?->slug;

    $safeRoute = function (string $routeName): string {
        return Route::has($routeName) ? route($routeName) : '#';
    };

    $satuanUrl = $safeRoute('admin.kategori-satuan.index');
    if ($satuanUrl === '#') {
        $satuanUrl = $safeRoute('admin.satuan.index');
    }

    $menus = match (true) {
        $roleSlug === 'admin' => [
            [
                'group' => 'MENU UTAMA',
                'label' => 'Dashboard',
                'url' => route('admin.dashboard'),
                'patterns' => ['admin.dashboard'],
                'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
            ],
            [
                'group' => 'MENU UTAMA',
                'label' => 'Manajemen User',
                'url' => route('admin.users.index'),
                'patterns' => ['admin.users.*'],
                'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
            ],
            [
                'group' => 'MENU UTAMA',
                'label' => 'Hak Akses',
                'url' => route('admin.hak-akses.index'),
                'patterns' => ['admin.hak-akses.*'],
                'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
            ],
            [
                'group' => 'MASTER DATA',
                'label' => 'Kategori Satuan',
                'url' => $satuanUrl,
                'patterns' => ['admin.kategori-satuan.*', 'admin.satuan.*'],
                'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
            ],
        ],
        in_array($roleSlug, ['pemilik_toko', 'pemilik'], true) => [
            [
                'group' => 'MENU UTAMA',
                'label' => 'Dashboard',
                'url' => route('pemilik.dashboard'),
                'patterns' => ['pemilik.dashboard'],
                'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
            ],
            [
                'group' => 'OPERASIONAL',
                'label' => 'Data Barang',
                'url' => $safeRoute('barang.index'),
                'patterns' => ['barang.*'],
                'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
            ],
            [
                'group' => 'OPERASIONAL',
                'label' => 'Pengecekan RORIS',
                'url' => $safeRoute('pemilik.roris.index'),
                'patterns' => ['pemilik.roris.index', 'pemilik.roris.create', 'pemilik.roris.show'],
                'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
            ],
            [
                'group' => 'OPERASIONAL',
                'label' => 'Pemasukan Harian',
                'url' => $safeRoute('pemilik.pemasukan.index'),
                'patterns' => ['pemilik.pemasukan.index', 'pemilik.pemasukan.create'],
                'icon' => 'M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z',
            ],
            [
                'group' => 'OPERASIONAL',
                'label' => 'Riwayat Pemasukan',
                'url' => $safeRoute('pemilik.pemasukan.riwayat'),
                'patterns' => ['pemilik.pemasukan.riwayat', 'pemilik.pemasukan.show', 'pemilik.pemasukan.edit'],
                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
            ],
            [
                'group' => 'LAPORAN',
                'label' => 'Laporan RORIS',
                'url' => $safeRoute('pemilik.roris.laporan'),
                'patterns' => ['pemilik.roris.laporan*'],
                'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
            ],
        ],
        default => [
            [
                'group' => 'MENU UTAMA',
                'label' => 'Dashboard',
                'url' => route('karyawan.dashboard'),
                'patterns' => ['karyawan.dashboard'],
                'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
            ],
            [
                'group' => 'OPERASIONAL',
                'label' => 'Data Barang',
                'url' => $safeRoute('barang.index'),
                'patterns' => ['barang.*'],
                'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
            ],
            [
                'group' => 'OPERASIONAL',
                'label' => 'Pemasukan Harian',
                'url' => $safeRoute('karyawan.pemasukan.index'),
                'patterns' => ['karyawan.pemasukan.index', 'karyawan.pemasukan.create'],
                'icon' => 'M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z',
            ],
            [
                'group' => 'OPERASIONAL',
                'label' => 'Riwayat Pemasukan',
                'url' => $safeRoute('karyawan.pemasukan.riwayat'),
                'patterns' => ['karyawan.pemasukan.riwayat', 'karyawan.pemasukan.show', 'karyawan.pemasukan.edit'],
                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
            ],
        ],
    };

    $roleLabel = in_array($roleSlug, ['pemilik_toko', 'pemilik'], true)
        ? 'Kepala Toko'
        : ($roleSlug === 'karyawan' ? 'Karyawan' : (auth()->user()->role?->nama ?? auth()->user()->role?->name ?? 'Admin'));
@endphp

<aside
    id="adminSidebar"
    class="fixed inset-y-0 left-0 z-50 flex h-screen w-[272px] shrink-0 -translate-x-full flex-col border-r border-line bg-white transition-transform duration-200 ease-out lg:sticky lg:top-0 lg:translate-x-0"
    aria-label="Navigasi utama"
>
    <!-- Brand -->
    <div class="flex items-center gap-3 border-b border-line px-5 py-5">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Kelola.in" class="h-10 w-10 shrink-0 object-contain">
        <div class="min-w-0 flex-1">
            <p class="truncate text-base font-black tracking-wide text-brand">KELOLA.IN</p>
            <p class="mt-0.5 truncate text-[10px] text-slate-500">Kelola Mudah Toko Terarah</p>
        </div>
        <button
            type="button"
            id="closeAdminSidebar"
            class="rounded-lg p-1.5 text-slate-500 transition hover:bg-brand/5 hover:text-brand lg:hidden"
            aria-label="Tutup menu"
        >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Menu -->
    <nav class="min-h-0 flex-1 space-y-1 overflow-y-auto px-3 py-4">
        @php $currentGroup = null; @endphp

        @foreach ($menus as $item)
            @if ($item['group'] !== $currentGroup)
                @php $currentGroup = $item['group']; @endphp
                <p class="px-3.5 pb-2 pt-3 text-[10px] font-semibold uppercase tracking-wider text-slate-400">
                    {{ $currentGroup }}
                </p>
            @endif

            @php
                $isActive = false;
                foreach ($item['patterns'] as $pattern) {
                    if (request()->routeIs($pattern)) {
                        $isActive = true;
                        break;
                    }
                }
                $isUnavailable = $item['url'] === '#';
            @endphp

            <a
                href="{{ $item['url'] }}"
                @if ($isUnavailable) aria-disabled="true" title="Modul ini belum tersedia" @endif
                class="group flex h-11 items-center gap-3 rounded-[10px] px-3.5 text-[13px] font-medium transition
                    {{ $isActive ? 'bg-brand text-white shadow-sm shadow-brand/20' : 'text-ink hover:bg-brand/5 hover:text-brand' }}"
            >
                <svg
                    class="h-5 w-5 shrink-0 {{ $isActive ? 'text-white' : 'text-slate-500 group-hover:text-brand' }}"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                </svg>
                <span class="truncate">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <!-- Profil & Logout: menempel di bawah -->
    <div class="mt-auto border-t border-line p-4">
        <div class="flex items-center gap-2">
            <a
                href="{{ route('profile.edit') }}"
                class="flex min-w-0 flex-1 items-center gap-3 rounded-[10px] p-2 transition hover:bg-brand/5"
                title="Buka Profil Saya"
            >
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand/10 text-xs font-bold uppercase text-brand">
                    {{ substr(auth()->user()->name, 0, 2) }}
                </span>
                <span class="min-w-0 flex-1 text-left">
                    <span class="block truncate text-xs font-semibold text-ink">{{ auth()->user()->name }}</span>
                    <span class="block truncate text-[11px] text-slate-500">{{ $roleLabel }}</span>
                </span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                @csrf
                <button
                    type="submit"
                    class="rounded-[10px] p-2 text-slate-500 transition hover:bg-rose-50 hover:text-rose-600"
                    title="Logout / Keluar"
                    aria-label="Logout"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
