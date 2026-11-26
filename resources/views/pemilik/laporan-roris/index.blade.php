@extends('layouts.app')

@section('title', 'Laporan RORIS')

@section('content')
    <div class="max-w-5xl mx-auto relative -top-4">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-xl font-bold text-[#0F2B5C]">Laporan RORIS</h1>
            <p class="text-xs text-slate-500 mt-0.5">Rekap pengecekan stok opname per periode.</p>
        </div>

        {{-- Form Filter Periode --}}
        <form method="GET" action="{{ route('pemilik.roris.laporan') }}"
            class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-6">
            <h2 class="text-sm font-bold text-slate-700 mb-4">Pilih Periode</h2>

            @if (!empty($errors))
                <div class="mb-4 px-4 py-3 bg-rose-50 border border-rose-200 text-rose-800 text-sm rounded-xl">
                    @foreach ($errors as $e)
                        <p>{{ $e }}</p>
                    @endforeach
                </div>
            @endif

            <div class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="text-xs font-semibold text-slate-600 block mb-1.5">
                        Tanggal Awal <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="dari" value="{{ request('dari') }}"
                        class="border border-slate-200 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 block mb-1.5">
                        Tanggal Akhir <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="sampai" value="{{ request('sampai') }}"
                        class="border border-slate-200 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <button type="submit"
                    class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">
                    Tampilkan
                </button>
            </div>
        </form>

        @if ($validated)
            {{-- Tombol Ekspor --}}
            <div class="flex justify-end gap-3 mb-4">
                <a href="{{ route('pemilik.roris.laporan.pdf', ['dari' => request('dari'), 'sampai' => request('sampai')]) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak PDF
                </a>
                <a href="{{ route('pemilik.roris.laporan.excel', ['dari' => request('dari'), 'sampai' => request('sampai')]) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Ekspor Excel
                </a>
            </div>

            {{-- Ringkasan Total --}}
            @if ($rorisList->isNotEmpty())
                <div class="grid grid-cols-3 gap-4 mb-5">
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 text-center">
                        <p class="text-xs text-slate-500 mb-1">Total Modal</p>
                        <p class="text-lg font-bold text-slate-800">
                            Rp {{ number_format($totalModal, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 text-center">
                        <p class="text-xs text-slate-500 mb-1">Total Pendapatan</p>
                        <p class="text-lg font-bold text-slate-800">
                            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 text-center">
                        <p class="text-xs text-slate-500 mb-1">Nilai RORIS</p>
                        <p class="text-lg font-bold {{ $nilaiRoris >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                            Rp {{ number_format($nilaiRoris, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Tabel Rekap --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                @if ($rorisList->isEmpty())
                    <div class="py-16 text-center text-slate-400">
                        <p class="text-sm font-medium">Tidak ada data RORIS pada periode yang dipilih.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50 text-xs text-slate-500 uppercase tracking-wider">
                                <tr>
                                    <th class="px-5 py-3 text-left">No. RORIS</th>
                                    <th class="px-5 py-3 text-left">Tanggal</th>
                                    <th class="px-5 py-3 text-left">Dibuat Oleh</th>
                                    <th class="px-5 py-3 text-right">Total Modal</th>
                                    <th class="px-5 py-3 text-right">Total Pendapatan</th>
                                    <th class="px-5 py-3 text-right">Nilai RORIS</th>
                                    <th class="px-5 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($rorisList as $r)
                                    <tr class="hover:bg-slate-50/60 transition">
                                        <td class="px-5 py-3 font-mono text-sm font-semibold text-slate-700">
                                            #RORIS-{{ str_pad($r->id, 4, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-5 py-3 font-semibold text-slate-800">
                                            {{ $r->tanggal->format('d-m-Y') }}
                                        </td>
                                        <td class="px-5 py-3 text-slate-600">{{ $r->user?->name ?? '-' }}</td>
                                        <td class="px-5 py-3 text-right text-slate-700">
                                            Rp {{ number_format($r->total_modal, 0, ',', '.') }}
                                        </td>
                                        <td class="px-5 py-3 text-right text-slate-700">
                                            Rp {{ number_format($r->total_pendapatan, 0, ',', '.') }}
                                        </td>
                                        <td
                                            class="px-5 py-3 text-right font-bold
                                                                        {{ $r->nilai_roris >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                            Rp {{ number_format($r->nilai_roris, 0, ',', '.') }}
                                        </td>
                                        <td class="px-5 py-3 text-center">
                                            <a href="{{ route('pemilik.roris.show', $r) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition"
                                                title="Lihat Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-slate-50 font-bold text-sm border-t border-slate-200">
                                <tr>
                                    <td colspan="4" class="px-5 py-3 text-right text-slate-600">Total Keseluruhan</td>
                                    <td class="px-5 py-3 text-right text-slate-800">
                                        Rp {{ number_format($totalModal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-3 text-right text-slate-800">
                                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-3 text-right {{ $nilaiRoris >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                        Rp {{ number_format($nilaiRoris, 0, ',', '.') }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection