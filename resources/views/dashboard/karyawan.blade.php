@extends('layouts.admin')

@section('title', 'Dashboard Karyawan')

@section('content')
    <!-- Banner Sapaan Karyawan / Kasir -->
    <div class="bg-[#EEF5FF] rounded-[22px] p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6 mb-7 relative overflow-hidden">
        <div class="z-10 text-center sm:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-100/80 text-amber-900 text-xs font-semibold uppercase tracking-wider mb-2">
                <span class="w-2 h-2 rounded-full bg-amber-600"></span>
                Karyawan / Kasir
            </div>
            <h1 class="text-2xl sm:text-[26px] font-bold text-[#0F2B5C] mb-1.5 tracking-tight">
                Selamat Bertugas, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-xs sm:text-sm text-[#64748B] font-medium max-w-xl">
                Akses operasional harian toko sembako: catat transaksi kasir pelanggan, periksa ketersediaan barang di etalase, dan kelola pemasukan.
            </p>
        </div>

        <!-- Ilustrasi Banner Kanan -->
        <div class="z-10 shrink-0">
            <div class="w-20 h-20 sm:w-24 sm:h-24 bg-[#1A6CF0] rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/25">
                <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Tiga Kartu Statistik Karyawan -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-7">
        <!-- 1. Transaksi Kasir -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition flex items-center gap-4">
            <div class="w-13 h-13 p-3.5 rounded-full bg-[#EEF5FF] text-[#1A6CF0] flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#64748B] mb-0.5">Sesi Kasir</p>
                <p class="text-2xl font-bold text-slate-900 tracking-tight">Aktif</p>
            </div>
        </div>

        <!-- 2. Katalog Barang -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition flex items-center gap-4">
            <div class="w-13 h-13 p-3.5 rounded-full bg-[#E6F9EE] text-[#10B981] flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#64748B] mb-0.5">Katalog Barang</p>
                <p class="text-2xl font-bold text-slate-900 tracking-tight">120 Item</p>
            </div>
        </div>

        <!-- 3. Status Operasional -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition flex items-center gap-4">
            <div class="w-13 h-13 p-3.5 rounded-full bg-[#FEF3C7] text-[#D97706] flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#64748B] mb-0.5">Operasional</p>
                <p class="text-2xl font-bold text-slate-900 tracking-tight">Siap Layani</p>
            </div>
        </div>
    </div>

    <!-- Dua Panel Bawah: Modul Operasional Kasir & Panduan Kerja -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Panel Kiri: Modul Operasional -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-base font-bold text-[#0F2B5C]">Operasional Toko</h2>
                    <span class="text-xs text-slate-400 font-medium">Tugas Kasir</span>
                </div>

                <div class="space-y-3">
                    <div class="p-3.5 rounded-xl bg-slate-50 hover:bg-blue-50/60 border border-slate-100 transition flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Transaksi Kasir</h3>
                                <p class="text-xs text-slate-500">Catat transaksi penjualan sembako kepada pembeli.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 hover:bg-blue-50/60 border border-slate-100 transition flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Cek Stok Barang</h3>
                                <p class="text-xs text-slate-500">Periksa persediaan sembako di etalase dan gudang.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 hover:bg-blue-50/60 border border-slate-100 transition flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Riwayat Penjualan</h3>
                                <p class="text-xs text-slate-500">Pantau catatan transaksi penjualan yang telah diselesaikan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Kanan: Petunjuk Operasional Kasir -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-base font-bold text-[#0F2B5C]">Petunjuk Kasir</h2>
                    <span class="text-xs text-slate-400 font-medium">Standar Toko</span>
                </div>

                <div class="space-y-3.5 text-xs text-slate-600">
                    <div class="p-3 rounded-xl bg-blue-50/50 border border-blue-100/50 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center shrink-0 font-bold text-[11px]">1</div>
                        <p class="pt-0.5"><strong class="text-slate-800">Periksa Jumlah Fisik:</strong> Pastikan barang yang diserahkan ke pembeli sesuai dengan nota penjualan.</p>
                    </div>
                    <div class="p-3 rounded-xl bg-emerald-50/50 border border-emerald-100/50 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0 font-bold text-[11px]">2</div>
                        <p class="pt-0.5"><strong class="text-slate-800">Pemasukan Tunai:</strong> Hitung uang tunai pembayaran dengan cermat dan berikan kembalian secara tepat.</p>
                    </div>
                    <div class="p-3 rounded-xl bg-amber-50/50 border border-amber-100/50 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center shrink-0 font-bold text-[11px]">3</div>
                        <p class="pt-0.5"><strong class="text-slate-800">Lapor Stok Menipis:</strong> Segera beri tahu Kepala Toko bila stok beras, telur, atau minyak menipis.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
