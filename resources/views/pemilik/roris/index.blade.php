@extends('layouts.app')

@section('title', 'Pengecekan RORIS')

@section('content')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-[#0F2B5C]">Pengecekan RORIS</h1>
            <p class="text-xs text-slate-500 mt-0.5">Input dan kelola data RORIS</p>
        </div>
        <a href="{{ route('pemilik.roris.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Input RORIS
        </a>
    </div>

    {{-- Flash success --}}
    @if (session('success'))
        <div
            class="mb-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-xl flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter --}}
    <form method="GET" action="{{ route('pemilik.roris.index') }}"
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
        <button type="submit"
            class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0" />
            </svg>
            Cari
        </button>
        @if (request('dari') || request('sampai') || request('status'))
            <a href="{{ route('pemilik.roris.index') }}"
                class="px-4 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-lg transition">
                Reset
            </a>
        @endif
    </form>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        @if ($rorisList->isEmpty())
            <div class="py-16 text-center text-slate-400">
                <svg class="w-10 h-10 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-sm font-medium">Data RORIS tidak ditemukan.</p>
            </div>
        @else
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No. RORIS
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal
                        </th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Nilai
                            RORIS</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($rorisList as $roris)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-5 py-3.5 font-mono text-sm font-semibold text-slate-700">
                                #RORIS-{{ str_pad($roris->id, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-700">
                                {{ $roris->tanggal->format('d-m-Y') }}
                            </td>
                            <td
                                class="px-5 py-3.5 text-right font-bold
                                                                            {{ $roris->nilai_roris >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                Rp {{ number_format($roris->nilai_roris, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <a href="{{ route('pemilik.roris.show', $roris) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition"
                                    title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Info pagination + Pagination --}}
            <div class="px-5 py-3 border-t border-slate-100 flex items-center justify-between gap-4">
                <p class="text-xs text-slate-400">
                    Menampilkan {{ $rorisList->firstItem() }}–{{ $rorisList->lastItem() }} dari {{ $rorisList->total() }} data
                </p>
                @if ($rorisList->hasPages())
                    <div>{{ $rorisList->links() }}</div>
                @endif
            </div>
        @endif
    </div>
@endsection