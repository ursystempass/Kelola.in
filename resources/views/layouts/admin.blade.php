<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Kelola.in</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#1A6CF0',
                        'brand-dark': '#155BD0',
                        'brand-active': '#114AB0',
                        ink: '#0F2B5C',
                        line: '#E5EAF3',
                        canvas: '#F5F7FB',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                },
            },
        };
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand: #1A6CF0;
            --brand-dark: #155BD0;
            --brand-active: #114AB0;
            --ink: #0F2B5C;
            --line: #E5EAF3;
            --canvas: #F5F7FB;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

@php
    $defaultTitle = match (true) {
        request()->routeIs('admin.dashboard') => 'Dashboard',
        request()->routeIs('admin.users.*') => 'Manajemen User',
        request()->routeIs('admin.hak-akses.*') => 'Hak Akses',
        request()->routeIs('admin.kategori-satuan.*'), request()->routeIs('admin.satuan.*') => 'Kategori Satuan',
        request()->routeIs('pemilik.dashboard') => 'Dashboard Pemilik Toko',
        request()->routeIs('karyawan.dashboard') => 'Dashboard Karyawan',
        request()->routeIs('profile.*') => 'Profil Saya',
        default => 'Dashboard',
    };
@endphp

<body class="h-screen overflow-hidden bg-canvas font-sans text-ink">
    <div id="adminApp" class="flex h-screen w-full overflow-hidden">
        <div id="adminSidebarBackdrop" class="fixed inset-0 z-40 hidden bg-slate-950/40 lg:hidden"></div>

        <x-admin-sidebar />

        <div class="flex min-w-0 flex-1 flex-col">
            <!-- Header sticky -->
            <header class="z-30 flex h-[72px] shrink-0 items-center justify-between gap-4 border-b border-line bg-white px-5 sm:px-7">
                <div class="flex min-w-0 items-center gap-3">
                    <button
                        type="button"
                        id="openAdminSidebar"
                        class="rounded-[10px] border border-line p-2 text-slate-600 transition hover:bg-brand/5 hover:text-brand lg:hidden"
                        aria-label="Buka menu"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <p class="text-[10px] font-medium uppercase tracking-wider text-slate-400">Kelola.in</p>
                        <h1 class="truncate text-base font-semibold text-ink sm:text-lg">@yield('title', $defaultTitle)</h1>
                    </div>
                </div>

                <div class="flex shrink-0 items-center gap-2 sm:gap-3">
                    <button
                        type="button"
                        class="relative rounded-[10px] p-2 text-slate-500 transition hover:bg-brand/5 hover:text-brand"
                        aria-label="Notifikasi"
                        title="Notifikasi"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute right-1.5 top-1.5 h-1.5 w-1.5 rounded-full bg-brand"></span>
                    </button>

                    <a
                        href="{{ route('profile.edit') }}"
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-brand text-xs font-semibold uppercase text-white transition hover:bg-brand-dark"
                        title="Profil: {{ auth()->user()->name }}"
                        aria-label="Profil {{ auth()->user()->name }}"
                    >
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </a>
                </div>
            </header>

            <!-- Satu-satunya area scroll -->
            <main class="min-h-0 flex-1 overflow-y-auto bg-canvas px-5 py-6 sm:px-7 sm:py-7">
                <div class="mx-auto w-full max-w-[1280px]">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('adminSidebarBackdrop');
            const openBtn = document.getElementById('openAdminSidebar');
            const closeBtn = document.getElementById('closeAdminSidebar');

            function openSidebar() {
                sidebar?.classList.remove('-translate-x-full');
                backdrop?.classList.remove('hidden');
            }

            function closeSidebar() {
                sidebar?.classList.add('-translate-x-full');
                backdrop?.classList.add('hidden');
            }

            openBtn?.addEventListener('click', openSidebar);
            closeBtn?.addEventListener('click', closeSidebar);
            backdrop?.addEventListener('click', closeSidebar);

            sidebar?.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', closeSidebar);
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            });
        });
    </script>
</body>

</html>
