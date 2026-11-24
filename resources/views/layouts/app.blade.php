<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Kelola.in</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#EEF4FE] min-h-screen p-2 sm:p-4 lg:p-6 flex items-center justify-center">

    <!-- Kontainer Utama Putih Membulat Besar -->
    <div
        class="w-full max-w-[1440px] min-h-[92vh] bg-white rounded-[28px] sm:rounded-[32px] shadow-2xl shadow-blue-900/5 border border-slate-100 flex flex-col lg:flex-row overflow-hidden relative">

        <!-- Backdrop Mobile Drawer -->
        <div id="mobileSidebarBackdrop" class="fixed inset-0 bg-slate-900/40 z-40 hidden lg:hidden transition-opacity">
        </div>

        <!-- Sidebar Kiri Sesuai Desain (Lebar ~220px, Latar #E8F0FE) -->
        <aside id="appSidebar"
            class="fixed lg:static inset-y-0 left-0 z-50 w-[220px] min-w-[220px] max-w-[220px] bg-[#E8F0FE] border-r border-[#D4E3FC] flex flex-col justify-between p-4 sm:p-5 shrink-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out">
            <div class="flex flex-col">
                <!-- Header Atas Rata Tengah: Logo + Brand + Tagline -->
                <div class="text-center flex flex-col items-center pt-2 pb-5 border-b border-[#D4E3FC]/60 relative">
                    <!-- Tombol Tutup Mobile (Hanya di layar kecil) -->
                    <button type="button" id="closeMobileSidebarBtn"
                        class="lg:hidden absolute top-0 right-0 text-slate-500 hover:text-slate-800 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Logo Tas Belanja -->
                    <div class="w-12 h-12 mb-2 flex items-center justify-center">
                        <img src="{{ asset('images/logo.svg') }}" alt="Logo Kelola.in" class="w-11 h-11 object-contain"
                            onerror="this.style.display='none'; document.getElementById('sidebar-logo-fallback').style.display='flex';">
                        <div id="sidebar-logo-fallback"
                            class="w-11 h-11 bg-[#2563EB] rounded-2xl items-center justify-center text-white shadow-md shadow-blue-500/25"
                            style="display: none;">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l2 2 4-4" />
                            </svg>
                        </div>
                    </div>

                    <!-- Teks KELOLA.IN & Tagline -->
                    <h1 class="text-lg font-extrabold tracking-wide text-[#0F2B5C] uppercase leading-tight">
                        KELOLA.IN
                    </h1>
                    <p class="text-[11px] font-medium text-[#475569] tracking-tight mt-0.5">
                        Kelola Mudah Toko Terarah
                    </p>
                </div>

                <!-- Daftar Menu Navigasi Sesuai Role -->
                @php
                    $roleSlug = auth()->user()->role?->slug;
                @endphp
                <nav class="mt-4 space-y-1">
                    {{-- 1. MENU ADMIN --}}
                    @if ($roleSlug === 'admin')
                        <!-- Dashboard -->
                        @php $isActive = request()->routeIs('admin.dashboard'); @endphp
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-[13px] font-semibold transition {{ $isActive ? 'bg-[#3B82F6] text-white shadow-md shadow-blue-500/20' : 'text-[#0F2B5C] hover:bg-[#D4E3FB]/70' }}">
                            <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-white' : 'text-[#0F2B5C]' }}" fill="none"
                                stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <!-- Manajemen User -->
                        @php $isActive = request()->routeIs('admin.users.*'); @endphp
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-[13px] font-semibold transition {{ $isActive ? 'bg-[#3B82F6] text-white shadow-md shadow-blue-500/20' : 'text-[#0F2B5C] hover:bg-[#D4E3FB]/70' }}">
                            <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-white' : 'text-[#0F2B5C]' }}" fill="none"
                                stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span>Manajemen User</span>
                        </a>

                        <!-- Hak Akses -->
                        @php $isActive = request()->routeIs('admin.hak-akses.*'); @endphp
                        <a href="{{ route('admin.hak-akses.index') }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-[13px] font-semibold transition {{ $isActive ? 'bg-[#3B82F6] text-white shadow-md shadow-blue-500/20' : 'text-[#0F2B5C] hover:bg-[#D4E3FB]/70' }}">
                            <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-white' : 'text-[#0F2B5C]' }}" fill="none"
                                stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>Hak Akses</span>
                        </a>

                        <!-- Kategori Satuan -->
                        @php
                            $satuanRoute = Route::has('admin.satuan.index')
                                ? route('admin.satuan.index')
                                : (Route::has('admin.kategori-satuan.index') ? route('admin.kategori-satuan.index') : '#');
                            $isActive = request()->routeIs('admin.satuan.*') || request()->routeIs('admin.kategori-satuan.*');
                        @endphp
                        <a href="{{ $satuanRoute }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-[13px] font-semibold transition {{ $isActive ? 'bg-[#3B82F6] text-white shadow-md shadow-blue-500/20' : 'text-[#0F2B5C] hover:bg-[#D4E3FB]/70' }}">
                            <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-white' : 'text-[#0F2B5C]' }}" fill="none"
                                stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <span>Kategori Satuan</span>
                        </a>

                        {{-- 2. MENU PEMILIK TOKO / KEPALA TOKO --}}
                    @elseif ($roleSlug === 'pemilik_toko' || $roleSlug === 'pemilik')
                        <!-- Dashboard -->
                        @php $isActive = request()->routeIs('pemilik.dashboard'); @endphp
                        <a href="{{ route('pemilik.dashboard') }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-[13px] font-semibold transition {{ $isActive ? 'bg-[#3B82F6] text-white shadow-md shadow-blue-500/20' : 'text-[#0F2B5C] hover:bg-[#D4E3FB]/70' }}">
                            <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-white' : 'text-[#0F2B5C]' }}" fill="none"
                                stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <!-- Data Barang -->
                        @php
                            $route = Route::has('barang.index') ? route('barang.index') : '#';
                            $isActive = request()->routeIs('barang.*');
                        @endphp
                        <a href="{{ $route }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-[13px] font-semibold transition {{ $isActive ? 'bg-[#3B82F6] text-white shadow-md shadow-blue-500/20' : 'text-[#0F2B5C] hover:bg-[#D4E3FB]/70' }}">
                            <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-white' : 'text-[#0F2B5C]' }}" fill="none"
                                stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <span>Data Barang</span>
                        </a>

                        <!-- Pengecekan RORIS -->
                        @php
                            $route = Route::has('pemilik.roris.index') ? route('pemilik.roris.index') : '#';
                            $isActive = request()->routeIs('pemilik.roris.*') && !request()->routeIs('pemilik.roris.laporan*');
                        @endphp
                        <a href="{{ $route }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-[13px] font-semibold transition {{ $isActive ? 'bg-[#3B82F6] text-white shadow-md shadow-blue-500/20' : 'text-[#0F2B5C] hover:bg-[#D4E3FB]/70' }}">
                            <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-white' : 'text-[#0F2B5C]' }}" fill="none"
                                stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            <span>Pengecekan RORIS</span>
                        </a>

                        <!-- Pemasukan Harian -->
                        @php
                            $route = Route::has('pemilik.pemasukan.index') ? route('pemilik.pemasukan.index') : '#';
                            $isActive = request()->routeIs('pemilik.pemasukan.index', 'pemilik.pemasukan.create');
                        @endphp
                        <a href="{{ $route }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-[13px] font-semibold transition {{ $isActive ? 'bg-[#3B82F6] text-white shadow-md shadow-blue-500/20' : 'text-[#0F2B5C] hover:bg-[#D4E3FB]/70' }}">
                            <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-white' : 'text-[#0F2B5C]' }}" fill="none"
                                stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                            </svg>
                            <span>Pemasukan Harian</span>
                        </a>

                        <!-- Riwayat Pemasukan -->
                        @php
                            $route = Route::has('pemilik.pemasukan.riwayat') ? route('pemilik.pemasukan.riwayat') : '#';
                            $isActive = request()->routeIs('pemilik.pemasukan.riwayat', 'pemilik.pemasukan.show');
                        @endphp
                        <a href="{{ $route }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-[13px] font-semibold transition {{ $isActive ? 'bg-[#3B82F6] text-white shadow-md shadow-blue-500/20' : 'text-[#0F2B5C] hover:bg-[#D4E3FB]/70' }}">
                            <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-white' : 'text-[#0F2B5C]' }}" fill="none"
                                stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Riwayat Pemasukan</span>
                        </a>

                        <!-- Laporan RORIS -->
                        @php
                            $route = Route::has('pemilik.roris.laporan') ? route('pemilik.roris.laporan') : '#';
                            $isActive = request()->routeIs('pemilik.roris.laporan*');
                        @endphp
                        <a href="{{ $route }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-[13px] font-semibold transition {{ $isActive ? 'bg-[#3B82F6] text-white shadow-md shadow-blue-500/20' : 'text-[#0F2B5C] hover:bg-[#D4E3FB]/70' }}">
                            <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-white' : 'text-[#0F2B5C]' }}" fill="none"
                                stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Laporan RORIS</span>
                        </a>

                        {{-- 3. MENU KARYAWAN --}}
                    @else
                        <!-- Dashboard -->
                        @php $isActive = request()->routeIs('karyawan.dashboard'); @endphp
                        <a href="{{ route('karyawan.dashboard') }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-[13px] font-semibold transition {{ $isActive ? 'bg-[#3B82F6] text-white shadow-md shadow-blue-500/20' : 'text-[#0F2B5C] hover:bg-[#D4E3FB]/70' }}">
                            <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-white' : 'text-[#0F2B5C]' }}" fill="none"
                                stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <!-- Data Barang -->
                        @php
                            $route = Route::has('barang.index') ? route('barang.index') : '#';
                            $isActive = request()->routeIs('barang.*');
                        @endphp
                        <a href="{{ $route }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-[13px] font-semibold transition {{ $isActive ? 'bg-[#3B82F6] text-white shadow-md shadow-blue-500/20' : 'text-[#0F2B5C] hover:bg-[#D4E3FB]/70' }}">
                            <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-white' : 'text-[#0F2B5C]' }}" fill="none"
                                stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <span>Data Barang</span>
                        </a>

                        <!-- Pemasukan Harian -->
                        @php
                            $route = Route::has('pemilik.pemasukan.index') ? route('pemilik.pemasukan.index') : '#';
                            $isActive = request()->routeIs('pemilik.pemasukan.index');
                        @endphp
                        <a href="{{ $route }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-[13px] font-semibold transition {{ $isActive ? 'bg-[#3B82F6] text-white shadow-md shadow-blue-500/20' : 'text-[#0F2B5C] hover:bg-[#D4E3FB]/70' }}">
                            <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-white' : 'text-[#0F2B5C]' }}" fill="none"
                                stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                            </svg>
                            <span>Pemasukan Harian</span>
                        </a>

                        <!-- Riwayat Pemasukan -->
                        @php
                            $route = Route::has('pemilik.pemasukan.riwayat') ? route('pemilik.pemasukan.riwayat') : '#';
                            $isActive = request()->routeIs('pemilik.pemasukan.riwayat');
                        @endphp
                        <a href="{{ $route }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-[13px] font-semibold transition {{ $isActive ? 'bg-[#3B82F6] text-white shadow-md shadow-blue-500/20' : 'text-[#0F2B5C] hover:bg-[#D4E3FB]/70' }}">
                            <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-white' : 'text-[#0F2B5C]' }}" fill="none"
                                stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Riwayat Pemasukan</span>
                        </a>
                    @endif
                </nav>
            </div>

            <!-- Bagian Bawah Menempel di Dasar: Profil User & Tombol Logout -->
            <div class="pt-4 border-t border-[#D4E3FC]/70 flex items-center justify-between gap-2">
                <!-- Info Pengguna Login (Dapat diklik menuju profil) -->
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-2.5 min-w-0 flex-1 hover:opacity-85 transition group"
                    title="Buka Profil Saya">
                    <!-- Avatar Bulat -->
                    <div
                        class="w-9 h-9 rounded-full bg-[#BFDBFE] text-[#1E40AF] flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition">
                        <svg class="w-5 h-5 text-[#1E40AF]" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <!-- Teks Nama & Role -->
                    <div class="min-w-0 flex-1 text-left">
                        <p class="text-xs font-bold text-[#0F2B5C] truncate group-hover:text-blue-600 transition">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-[11px] text-[#475569] font-medium truncate">
                            {{ in_array(auth()->user()->role?->slug, ['pemilik_toko', 'pemilik']) ? 'Kepala Toko' : (auth()->user()->role?->slug === 'karyawan' ? 'Karyawan' : (auth()->user()->role?->nama ?? auth()->user()->role?->name ?? 'Admin')) }}
                        </p>
                    </div>
                </a>

                <!-- Tombol Logout Berupa Form POST -->
                <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                    @csrf
                    <button type="submit"
                        class="p-1.5 text-[#0F2B5C] hover:text-rose-600 hover:bg-white/60 rounded-lg transition duration-150"
                        title="Logout / Keluar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Area Konten Kanan -->
        <div class="flex-1 flex flex-col min-w-0 bg-white">

            <!-- Topbar Sederhana Sesuai Desain -->
            <header
                class="h-16 px-6 sm:px-8 lg:px-9 flex items-center justify-between border-b border-slate-50/80 shrink-0">
                <!-- Tombol Menu Mobile (Hanya di layar < lg) -->
                <button type="button" id="openMobileSidebarBtn"
                    class="lg:hidden text-slate-600 hover:text-slate-900 p-2 rounded-xl border border-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="hidden lg:block"></div>

                <!-- Bagian Kanan Topbar: Ikon Lonceng Notifikasi & Avatar Inisial -->
                <div class="flex items-center gap-3">
                    <!-- Avatar Inisial Bulat (Dapat diklik menuju Profil) -->
                    <a href="{{ route('profile.edit') }}" title="Pengaturan Profil: {{ auth()->user()->name }}"
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-[#1E293B] hover:bg-[#0F172A] text-white text-xs font-bold uppercase tracking-wider transition shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </a>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-5 sm:p-7 lg:p-9 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Script Drawer Sidebar Mobile -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const openBtn = document.getElementById('openMobileSidebarBtn');
            const closeBtn = document.getElementById('closeMobileSidebarBtn');
            const sidebar = document.getElementById('appSidebar');
            const backdrop = document.getElementById('mobileSidebarBackdrop');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }

            if (openBtn) openBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);
        });
    </script>
</body>

</html>