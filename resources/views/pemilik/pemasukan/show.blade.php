@extends('layouts.app')

@section('title', 'Detail Pemasukan')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pemilik.pemasukan.riwayat') }}"
           class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-xl font-bold text-[#0F2B5C] font-mono">
                    #PMS-{{ str_pad($pemasukan->id, 4, '0', STR_PAD_LEFT) }}
                </h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $pemasukan->badgeMetodeClass() }}">
                    {{ $pemasukan->labelMetode() }}
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-0.5">
                Tanggal {{ $pemasukan->tanggal->format('d-m-Y') }} &bull; Dicatat oleh {{ $pemasukan->user?->name ?? '-' }}
            </p>
        </div>
    </div>

    {{-- Kartu Ringkasan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <p class="text-xs text-slate-500 mb-1">Total Pemasukan</p>
            <p class="text-xl font-bold text-emerald-600">
                Rp {{ number_format($pemasukan->total_pemasukan, 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <p class="text-xs text-slate-500 mb-1">Jumlah Item Terjual</p>
            <p class="text-xl font-bold text-slate-800">
                {{ $pemasukan->details->count() }} Item
            </p>
        </div>
    </div>

    {{-- Catatan --}}
    @if ($pemasukan->catatan)
        <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 mb-5 text-sm text-amber-800">
            <span class="font-semibold">Catatan:</span> {{ $pemasukan->catatan }}
        </div>
    @endif

    {{-- Tabel Rincian Barang --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-700">Rincian Barang ({{ $pemasukan->details->count() }} item)</h2>
        </div>

        @if ($pemasukan->details->isEmpty())
            <div class="py-12 text-center text-slate-400 text-sm">Tidak ada rincian barang.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-xs text-slate-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-5 py-3 text-left">No</th>
                            <th class="px-5 py-3 text-left">Nama Barang</th>
                            <th class="px-5 py-3 text-left">Satuan</th>
                            <th class="px-5 py-3 text-right">Qty</th>
                            <th class="px-5 py-3 text-right">Harga Satuan</th>
                            <th class="px-5 py-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($pemasukan->details as $index => $detail)
                            <tr>
                                <td class="px-5 py-3 text-slate-500">{{ $index + 1 }}</td>
                                <td class="px-5 py-3 font-medium text-slate-800">{{ $detail->nama_barang }}</td>
                                <td class="px-5 py-3 text-slate-600">{{ $detail->satuan }}</td>
                                <td class="px-5 py-3 text-right text-slate-700">{{ number_format($detail->qty, 2, ',', '.') }}</td>
                                <td class="px-5 py-3 text-right text-slate-700">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td class="px-5 py-3 text-right font-semibold text-slate-800">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection