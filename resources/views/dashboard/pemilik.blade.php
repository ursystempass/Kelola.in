@extends('layouts.app')

@section('title', 'Dashboard Pemilik Toko')

@section('content')
    <!-- Banner Sapaan Kepala Toko / Pemilik -->
    <div class="bg-[#EEF5FF] rounded-[22px] p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6 mb-7 relative overflow-hidden">
        <div class="z-10 text-center sm:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100/80 text-blue-800 text-xs font-semibold uppercase tracking-wider mb-2">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                Kepala Toko / Pemilik
            </div>
            <h1 class="text-2xl sm:text-[26px] font-bold text-[#0F2B5C] mb-1.5 tracking-tight">
                Selamat Datang, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-xs sm:text-sm text-[#64748B] font-medium max-w-xl">
                Pantau kinerja bisnis toko sembako Anda: omset harian, tren transaksi penjualan, serta status ketersediaan barang secara real-time.
            </p>
        </div>

        <!-- Ilustrasi Banner Kanan -->
        <div class="z-10 shrink-0">
            <div class="w-20 h-20 sm:w-24 sm:h-24 bg-[#1A6CF0] rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/25">
                <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l2 2 4-4" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Tiga Kartu Statistik Berderet Sesuai Desain Kelola.in -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-7">
        <!-- 1. Total User / Staf -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition flex items-center gap-4">
            <div class="w-13 h-13 p-3.5 rounded-full bg-[#EEF5FF] text-[#1A6CF0] flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#64748B] mb-0.5">Total Pengguna</p>
                <p class="text-2xl font-bold text-slate-900 tracking-tight">{{ \App\Models\User::count() }}</p>
            </div>
        </div>

        <!-- 2. Total Barang Terdaftar -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition flex items-center gap-4">
            <div class="w-13 h-13 p-3.5 rounded-full bg-[#E6F9EE] text-[#10B981] flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#64748B] mb-0.5">Total Barang</p>
                <p class="text-2xl font-bold text-slate-900 tracking-tight">120 Item</p>
            </div>
        </div>

        <!-- 3. Total Transaksi Hari Ini -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition flex items-center gap-4">
            <div class="w-13 h-13 p-3.5 rounded-full bg-[#F3E8FF] text-[#9333EA] flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#64748B] mb-0.5">Total Transaksi</p>
               <p class="text-2xl font-bold text-slate-900 tracking-tight">{{ $totalTransaksiHariIni }}</p>
            </div>
        </div>
    </div>

    <!-- Dua Panel Bawah: Ringkasan Sistem Toko & Akses Cepat Modul -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Panel Kiri: Ringkasan Sistem Toko -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-base font-bold text-[#0F2B5C]">Ringkasan Toko</h2>
                    <span class="text-xs text-slate-400 font-medium">Hari Ini</span>
                </div>

                <div class="divide-y divide-slate-100 text-sm">
                    <div class="py-3.5 flex items-center justify-between">
                        <span class="text-slate-600 font-medium flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            Pengguna Aktif
                        </span>
                        <span class="font-bold text-slate-900">{{ \App\Models\User::where('is_active', true)->count() }} Orang</span>
                    </div>
                    <div class="py-3.5 flex items-center justify-between">
                        <span class="text-slate-600 font-medium flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                            Barang Terdaftar
                        </span>
                        <span class="font-bold text-slate-900">120 Item</span>
                    </div>
                    <div class="py-3.5 flex items-center justify-between">
                        <span class="text-slate-600 font-medium flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                            Pengecekan RORIS
                        </span>
                        <span class="font-bold text-slate-900">45 Transaksi</span>
                    </div>
                    <div class="py-3.5 flex items-center justify-between">
                        <span class="text-slate-600 font-medium flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Pemasukan Hari Ini
                        </span>
                        <span class="font-bold text-emerald-600">Rp {{ number_format($pemasukanHariIni, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Kanan: Akses Cepat Modul Kepala Toko -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-base font-bold text-[#0F2B5C]">Akses Cepat Modul</h2>
                    <span class="text-xs text-slate-400 font-medium">Navigasi Utama</span>
                </div>

                <div class="space-y-3">
                    <div class="p-3.5 rounded-xl bg-slate-50 hover:bg-blue-50/60 border border-slate-100 transition flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Katalog & Data Barang</h3>
                                <p class="text-xs text-slate-500">Kelola daftar stok, harga beli/jual, dan ketersediaan sembako.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 hover:bg-blue-50/60 border border-slate-100 transition flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Pengecekan RORIS</h3>
                                <p class="text-xs text-slate-500">Monitoring re-order point dan stok minimum sembako.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 hover:bg-blue-50/60 border border-slate-100 transition flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" /></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Pemasukan & Laporan</h3>
                                <p class="text-xs text-slate-500">Pantau rekapitulasi omset penjualan dan riwayat transaksi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian Riwayat Pemasukan (Immanuel) --}}
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm mt-6">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-base font-bold text-[#0F2B5C]">Riwayat Pemasukan Terbaru</h2>
                <p class="text-xs text-slate-400 mt-0.5">5 transaksi pemasukan terakhir yang dicatat</p>
            </div>
            <a href="{{ route('pemilik.pemasukan.riwayat') }}" class="text-xs font-semibold text-[#1A6CF0] hover:underline flex items-center gap-1">
                <span>Lihat semua riwayat</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        @if ($riwayatPemasukan->isEmpty())
            <div class="py-10 text-center text-slate-400 text-sm">
                Belum ada riwayat pemasukan yang tercatat.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-4 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No. Transaksi</th>
                            <th class="px-4 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Metode</th>
                            <th class="px-4 py-2.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Item</th>
                            <th class="px-4 py-2.5 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Total</th>
                            <th class="px-4 py-2.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($riwayatPemasukan as $item)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-4 py-3 font-mono text-xs font-semibold text-slate-700">
                                    #PMS-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-4 py-3 text-slate-600">
                                    {{ $item->tanggal->format('d-m-Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $item->badgeMetodeClass() }}">
                                        {{ $item->labelMetode() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-slate-600">
                                    {{ $item->details_count }} item
                                </td>
                                <td class="px-4 py-3 text-right font-bold text-emerald-600">
                                    Rp {{ number_format($item->total_pemasukan, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('pemilik.pemasukan.show', $item) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition"
                                       title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @include('dashboard.partials.grafik-roris')
@endsection
