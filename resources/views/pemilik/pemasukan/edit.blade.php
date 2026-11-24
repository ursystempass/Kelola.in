@extends('layouts.app')

@section('title', 'Ubah Data Pemasukan')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pemilik.pemasukan.show', $pemasukan) }}"
           class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-[#0F2B5C]">
                Ubah Pemasukan <span class="font-mono">#PMS-{{ str_pad($pemasukan->id, 4, '0', STR_PAD_LEFT) }}</span>
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Perbarui tanggal, metode bayar, catatan, atau rincian barang terjual.</p>
        </div>
    </div>

    {{-- Error Validasi --}}
    @if ($errors->any())
        <div class="mb-4 px-4 py-3 bg-rose-50 border border-rose-200 text-rose-800 text-sm rounded-xl">
            <p class="font-semibold mb-1">Mohon perbaiki kesalahan berikut:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('pemilik.pemasukan.update', $pemasukan) }}" id="pemasukanForm"
    onsubmit="return confirm('Simpan perubahan data pemasukan ini?')">
        @csrf
        @method('PUT')

        {{-- Informasi Utama --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-5">
            <h2 class="text-sm font-bold text-slate-700 mb-4">Informasi Pemasukan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="text-xs font-semibold text-slate-600 block mb-1.5">
                        Tanggal <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $pemasukan->tanggal->format('Y-m-d')) }}"
                           class="w-full border border-slate-200 rounded-xl px-3.5 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-400
                                  @error('tanggal') border-rose-400 @enderror">
                    @error('tanggal')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-xs font-semibold text-slate-600 block mb-1.5">
                        Metode Bayar <span class="text-rose-500">*</span>
                    </label>
                    @php $selectedMetode = old('metode_bayar', $pemasukan->metode_bayar); @endphp
                    <select name="metode_bayar"
                            class="w-full border border-slate-200 rounded-xl px-3.5 py-2 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-blue-400
                                   @error('metode_bayar') border-rose-400 @enderror">
                        <option value="tunai" {{ $selectedMetode === 'tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="transfer" {{ $selectedMetode === 'transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="qris" {{ $selectedMetode === 'qris' ? 'selected' : '' }}>QRIS</option>
                    </select>
                    @error('metode_bayar')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-xs font-semibold text-slate-600 block mb-1.5">Catatan (Opsional)</label>
                    <input type="text" name="catatan" value="{{ old('catatan', $pemasukan->catatan) }}"
                           placeholder="Misal: Penjualan shift pagi"
                           class="w-full border border-slate-200 rounded-xl px-3.5 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
            </div>
        </div>

        {{-- Tabel Detail Barang --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-slate-700">Rincian Barang Terjual</h2>
                <button type="button" id="tambahBaris"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100
                               text-emerald-700 text-xs font-semibold rounded-lg transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Baris
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-xs text-slate-500 uppercase tracking-wider">
                            <th class="px-3 py-2.5 text-left rounded-tl-lg">Nama Barang</th>
                            <th class="px-3 py-2.5 text-left">Satuan</th>
                            <th class="px-3 py-2.5 text-right">Qty</th>
                            <th class="px-3 py-2.5 text-right">Harga Satuan (Rp)</th>
                            <th class="px-3 py-2.5 text-right rounded-tr-lg">Subtotal</th>
                            <th class="px-3 py-2.5"></th>
                        </tr>
                    </thead>
                    <tbody id="tabelBody">
                        @php
                            $rows = old('details', $pemasukan->details->map(fn ($d) => [
                                'nama_barang'  => $d->nama_barang,
                                'satuan'       => $d->satuan,
                                'qty'          => (float) $d->qty,
                                'harga_satuan' => (float) $d->harga_satuan,
                            ])->toArray());
                        @endphp

                        @foreach ($rows as $i => $d)
                            <tr class="border-t border-slate-100 baris-detail">
                                <td class="px-2 py-2">
                                    <input type="text" name="details[{{ $i }}][nama_barang]"
                                           value="{{ $d['nama_barang'] ?? '' }}" placeholder="Nama barang"
                                           class="w-full min-w-[160px] border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
                                </td>
                                <td class="px-2 py-2">
                                    <input type="text" name="details[{{ $i }}][satuan]"
                                           value="{{ $d['satuan'] ?? '' }}" placeholder="Kg / Pcs"
                                           class="w-24 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
                                </td>
                                <td class="px-2 py-2">
                                    <input type="number" name="details[{{ $i }}][qty]"
                                           value="{{ $d['qty'] ?? '' }}" min="0.01" step="0.01" placeholder="0"
                                           class="input-qty w-24 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs text-right focus:outline-none focus:ring-1 focus:ring-blue-400">
                                </td>
                                <td class="px-2 py-2">
                                    <input type="number" name="details[{{ $i }}][harga_satuan]"
                                           value="{{ $d['harga_satuan'] ?? '' }}" min="0" step="1" placeholder="0"
                                           class="input-harga w-32 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs text-right focus:outline-none focus:ring-1 focus:ring-blue-400">
                                </td>
                                <td class="px-2 py-2 text-right text-xs text-slate-700 subtotal-baris font-semibold">Rp 0</td>
                                <td class="px-2 py-2 text-center">
                                    <button type="button" class="hapus-baris text-rose-400 hover:text-rose-600 transition p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Ringkasan Total --}}
                <div class="mt-5 pt-4 border-t border-slate-100 flex flex-wrap justify-end gap-6">
                <div class="text-right">
                    <p class="text-xs text-slate-400">Total Sebelumnya</p>
                    <p class="text-sm font-semibold text-slate-500">
                        Rp {{ number_format($pemasukan->total_pemasukan, 0, ',', '.') }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-500">Total Setelah Diubah</p>
                    <p id="previewTotal" class="text-base font-bold text-emerald-600">Rp 0</p>
                </div>
        </div>

        {{-- Tombol Submit --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('pemilik.pemasukan.show', $pemasukan) }}"
               class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
(function () {
    const fmt = v => 'Rp ' + Number(v).toLocaleString('id-ID');

    function hitungTotal() {
        let total = 0;
        document.querySelectorAll('.baris-detail').forEach(tr => {
            const qty   = parseFloat(tr.querySelector('.input-qty')?.value) || 0;
            const harga = parseFloat(tr.querySelector('.input-harga')?.value) || 0;
            const sub   = qty * harga;
            tr.querySelector('.subtotal-baris').textContent = fmt(sub);
            total += sub;
        });
        document.getElementById('previewTotal').textContent = fmt(total);
    }

    function reIndex() {
        document.querySelectorAll('.baris-detail').forEach((tr, i) => {
            tr.querySelectorAll('input[name]').forEach(inp => {
                inp.name = inp.name.replace(/details\[\d+\]/, `details[${i}]`);
            });
        });
    }

    function buatBaris(idx) {
        const tr = document.createElement('tr');
        tr.className = 'border-t border-slate-100 baris-detail';
        tr.innerHTML = `
            <td class="px-2 py-2">
                <input type="text" name="details[${idx}][nama_barang]" placeholder="Nama barang"
                       class="w-full min-w-[160px] border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
            </td>
            <td class="px-2 py-2">
                <input type="text" name="details[${idx}][satuan]" placeholder="Kg / Pcs"
                       class="w-24 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
            </td>
            <td class="px-2 py-2">
                <input type="number" name="details[${idx}][qty]" min="0.01" step="0.01" placeholder="0"
                       class="input-qty w-24 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs text-right focus:outline-none focus:ring-1 focus:ring-blue-400">
            </td>
            <td class="px-2 py-2">
                <input type="number" name="details[${idx}][harga_satuan]" min="0" step="1" placeholder="0"
                       class="input-harga w-32 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs text-right focus:outline-none focus:ring-1 focus:ring-blue-400">
            </td>
            <td class="px-2 py-2 text-right text-xs text-slate-700 subtotal-baris font-semibold">Rp 0</td>
            <td class="px-2 py-2 text-center">
                <button type="button" class="hapus-baris text-rose-400 hover:text-rose-600 transition p-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </td>
        `;
        return tr;
    }

    const tbody = document.getElementById('tabelBody');

    tbody.addEventListener('input', function (e) {
        if (e.target.matches('.input-qty, .input-harga')) {
            hitungTotal();
        }
    });

    document.getElementById('tambahBaris').addEventListener('click', function () {
        const idx = document.querySelectorAll('.baris-detail').length;
        tbody.appendChild(buatBaris(idx));
    });

    tbody.addEventListener('click', function (e) {
        const btn = e.target.closest('.hapus-baris');
        if (!btn) return;
        if (document.querySelectorAll('.baris-detail').length <= 1) {
            alert('Minimal harus ada satu baris barang.');
            return;
        }
        btn.closest('tr').remove();
        reIndex();
        hitungTotal();
    });

    hitungTotal();
})();
</script>
@endsection