@extends('layouts.app')

@section('title', 'Detail RORIS')

@section('content')
    <div class="max-w-5xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('pemilik.roris.index') }}"
                class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-xl font-bold text-[#0F2B5C] font-mono">
                        #RORIS-{{ str_pad($roris->id, 4, '0', STR_PAD_LEFT) }}
                    </h1>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">
                    Tanggal {{ $roris->tanggal->format('d-m-Y') }} &bull; {{ $roris->user?->name ?? '-' }}
                </p>
            </div>
        </div>

        {{-- Kartu Ringkasan --}}
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 text-center">
                <p class="text-xs text-slate-500 mb-1">Total Modal</p>
                <p class="text-lg font-bold text-slate-800">
                    Rp {{ number_format($roris->total_modal, 0, ',', '.') }}
                </p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 text-center">
                <p class="text-xs text-slate-500 mb-1">Total Pendapatan</p>
                <p class="text-lg font-bold text-slate-800">
                    Rp {{ number_format($roris->total_pendapatan, 0, ',', '.') }}
                </p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 text-center">
                <p class="text-xs text-slate-500 mb-1">Nilai RORIS</p>
                <p class="text-lg font-bold {{ $roris->nilai_roris >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                    Rp {{ number_format($roris->nilai_roris, 0, ',', '.') }}
                </p>
            </div>
        </div>

        {{-- Info Header --}}
        @if ($roris->catatan)
            <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 mb-5 text-sm text-amber-800">
                <span class="font-semibold">Catatan:</span> {{ $roris->catatan }}
            </div>
        @endif

        {{-- Tabel Rincian --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-700">Rincian Barang ({{ $roris->details->count() }} item)</h2>
            </div>

            @if ($roris->details->isEmpty())
                <div class="py-12 text-center text-slate-400 text-sm">Tidak ada rincian barang.</div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-xs text-slate-500 uppercase tracking-wider">
                            <tr>
                                <th class="px-5 py-3 text-left">No</th>
                                <th class="px-5 py-3 text-left">Kode</th>
                                <th class="px-5 py-3 text-left">Nama Barang</th>
                                <th class="px-5 py-3 text-left">Satuan</th>
                                <th class="px-5 py-3 text-right">Qty Fisik</th>
                                <th class="px-5 py-3 text-right">Harga Modal</th>
                                <th class="px-5 py-3 text-right">Harga Jual</th>
                                <th class="px-5 py-3 text-right">Subtotal Modal</th>
                                <th class="px-5 py-3 text-right">Subtotal Pend.</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach ($roris->details as $d)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-5 py-3 text-slate-500">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-3 font-mono text-xs text-slate-700">{{ $d->kode_barang }}</td>
                                    <td class="px-5 py-3 font-semibold text-slate-800">{{ $d->nama_barang }}</td>
                                    <td class="px-5 py-3 text-slate-600">{{ $d->satuan }}</td>
                                    <td class="px-5 py-3 text-right text-slate-700">
                                        {{ number_format($d->qty_fisik, 2, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-3 text-right text-slate-700">
                                        Rp {{ number_format($d->harga_modal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-3 text-right text-slate-700">
                                        Rp {{ number_format($d->harga_jual, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-3 text-right text-slate-700">
                                        Rp {{ number_format($d->subtotal_modal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-3 text-right font-semibold text-slate-800">
                                        Rp {{ number_format($d->subtotal_pendapatan, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-slate-50 font-bold text-sm border-t border-slate-200">
                            <tr>
                                <td colspan="7" class="px-5 py-3 text-right text-slate-600">Total</td>
                                <td class="px-5 py-3 text-right text-slate-800">
                                    Rp {{ number_format($roris->total_modal, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3 text-right text-slate-800">
                                    Rp {{ number_format($roris->total_pendapatan, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection