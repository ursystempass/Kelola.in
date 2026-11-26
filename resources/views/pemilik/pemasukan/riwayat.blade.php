@extends('layouts.app')

@section('title', 'Riwayat Pemasukan')

@section('content')
{{-- Header --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-xl font-bold text-[#0F2B5C]">Riwayat Pemasukan</h1>
        <p class="text-xs text-slate-500 mt-0.5">Telusuri seluruh riwayat pemasukan berdasarkan rentang tanggal dan metode bayar.</p>
    </div>
    <div class="bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-2 text-right">
        <p class="text-[11px] font-semibold text-emerald-700">Total Periode Terfilter</p>
        <p class="text-base font-bold text-emerald-600">Rp {{ number_format($totalPeriode, 0, ',', '.') }}</p>
    </div>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('pemilik.pemasukan.riwayat') }}"
      class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-6 flex flex-wrap items-end gap-3">
    <div>
        <label class="text-xs font-semibold text-slate-600 block mb-1">Filter Tanggal</label>
        <div class="flex items-center gap-2">
            <input type="date" name="dari" value="{{ request('dari') }}"
                   class="border border-slate-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <span class="text-slate-400 text-xs">s/d</span>
            <input type="date" name="sampai" value="{{ request('sampai') }}"
                   class="border border-slate-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
    </div>
    <div>
        <label class="text-xs font-semibold text-slate-600 block mb-1">Metode Bayar</label>
        <select name="metode_bayar"
                class="border border-slate-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Semua Metode</option>
            <option value="tunai" {{ request('metode_bayar') === 'tunai' ? 'selected' : '' }}>Tunai</option>
            <option value="transfer" {{ request('metode_bayar') === 'transfer' ? 'selected' : '' }}>Transfer</option>
            <option value="qris" {{ request('metode_bayar') === 'qris' ? 'selected' : '' }}>QRIS</option>
        </select>
    </div>
    <button type="submit"
            class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
        </svg>
        Cari
    </button>
    @if (request('dari') || request('sampai') || request('metode_bayar'))
        <a href="{{ route('pemilik.pemasukan.riwayat') }}"
           class="px-4 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-lg transition">
            Reset
        </a>
    @endif
</form>

{{-- Tabel Riwayat --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    @if ($pemasukanList->isEmpty())
        <div class="py-16 text-center text-slate-400">
            <svg class="w-10 h-10 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-medium">Data riwayat pemasukan tidak ditemukan.</p>
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
                                    <p class="text-xs text-slate-400 mt-0.5 truncate max-w-[220px]">{{ $item->catatan }}</p>
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
                            
                            <td class="px-5 py-3.5 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('pemilik.pemasukan.show', $item) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition"
                                    title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('pemilik.pemasukan.edit', $item) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg transition"
                                    title="Ubah Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>   
                        </tr>
                    @endforeach
                </tbody>
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