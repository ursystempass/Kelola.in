@extends('layouts.app')

@section('title', 'Pemasukan Harian')

@section('content')
{{-- Header --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-xl font-bold text-[#0F2B5C]">Pemasukan Harian</h1>
        <p class="text-xs text-slate-500 mt-0.5">Catat dan hitung total pemasukan harian toko sembako.</p>
    </div>
    <a href="{{ route('pemilik.pemasukan.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Catat Pemasukan
    </a>
</div>

{{-- Flash success --}}
@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-xl flex items-center gap-2">
        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

{{-- Pilih Tanggal untuk Hitung Total Harian --}}
<form method="GET" action="{{ route('pemilik.pemasukan.index') }}"
      class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-5 flex flex-wrap items-end gap-3">
    <div>
        <label class="text-xs font-semibold text-slate-600 block mb-1">Tanggal Perhitungan</label>
        <input type="date" name="tanggal" value="{{ $tanggal }}"
               class="border border-slate-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <button type="submit"
            class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition">
        Hitung Total
    </button>
    @if ($tanggal !== now()->toDateString())
        <a href="{{ route('pemilik.pemasukan.index') }}"
           class="px-4 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-lg transition">
            Hari Ini
        </a>
    @endif
</form>

{{-- Ringkasan Total Harian --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-[#E6F9EE] text-[#10B981] flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-[#64748B] mb-0.5">
                Total Harian ({{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }})
            </p>
            <p class="text-xl font-bold text-emerald-600 tracking-tight">
                Rp {{ number_format($totalHarian, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-[#EEF5FF] text-[#1A6CF0] flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-[#64748B] mb-0.5">Jumlah Transaksi</p>
            <p class="text-xl font-bold text-slate-900 tracking-tight">{{ $jumlahTransaksi }} Transaksi</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-[#FEF3C7] text-[#D97706] flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-[#64748B] mb-0.5">Tunai / Non-Tunai</p>
            <p class="text-sm font-bold text-slate-900">
                Rp {{ number_format($totalTunai, 0, ',', '.') }}
                <span class="text-slate-400 font-normal">/</span>
                Rp {{ number_format($totalNonTunai, 0, ',', '.') }}
            </p>
        </div>
    </div>
</div>

{{-- Tabel Daftar Pemasukan pada Tanggal Terpilih --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    @if ($pemasukanList->isEmpty())
        <div class="py-16 text-center text-slate-400">
            <svg class="w-10 h-10 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
            </svg>
            <p class="text-sm font-medium">Tidak ada pemasukan pada tanggal {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No. Transaksi</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Metode</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Jumlah Item</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Pemasukan</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Dicatat Oleh</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($pemasukanList as $item)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-5 py-3.5">
                                <span class="font-mono text-sm font-semibold text-slate-700">
                                #PMS-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                                @if ($item->catatan)
                                <p class="text-xs text-slate-400 mt-0.5 truncate max-w-[200px]">{{ $item->catatan }}</p>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-slate-700">
                                {{ $item->tanggal->format('d-m-Y') }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $item->badgeMetodeClass() }}">
                                    {{ $item->labelMetode() }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center text-slate-600">
                                {{ $item->details_count }} item
                            </td>
                            <td class="px-5 py-3.5 text-right font-bold text-emerald-600">
                                Rp {{ number_format($item->total_pemasukan, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">
                                {{ $item->user?->name ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
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
                <tfoot class="bg-slate-50 border-t border-slate-100">
                 <tr>
                    <td colspan="4" class="px-5 py-3 text-right text-xs font-bold text-slate-600 uppercase">
                        Total Pemasukan ({{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }})
                    </td>
                    <td class="px-5 py-3 text-right text-sm font-bold text-emerald-600">
                        Rp {{ number_format($totalHarian, 0, ',', '.') }}
                    </td>
                    <td></td>
                    <td></td>
                    </tr>
                    </tfoot>   
            </table>
        </div>

        @if ($pemasukanList->hasPages())
            <div class="px-5 py-3.5 border-t border-slate-100">
                {{ $pemasukanList->links() }}
            </div>
        @endif
    @endif
</div>
@endsection