@extends('layouts.app')

@section('title', 'Tambah RORIS')

@section('content')
    <div class="max-w-5xl mx-auto relative -top-4">

        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('pemilik.roris.index') }}"
                class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-[#0F2B5C]">Tambah RORIS Baru</h1>
                <p class="text-xs text-slate-500 mt-0.5">Input pengecekan / stok opname seluruh barang.</p>
            </div>
        </div>

        {{-- Error Bag --}}
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

        <form method="POST" action="{{ route('pemilik.roris.store') }}" id="rorisForm">
            @csrf

            {{-- Header Form --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-5">
                <h2 class="text-sm font-bold text-slate-700 mb-4">Informasi RORIS</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="text-xs font-semibold text-slate-600 block mb-1.5">
                            Tanggal RORIS <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="w-full border border-slate-200 rounded-xl px-3.5 py-2 text-sm
                                                  focus:outline-none focus:ring-2 focus:ring-blue-400
                                                  @error('tanggal') border-rose-400 @enderror">
                        @error('tanggal')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-600 block mb-1.5">Catatan (Opsional)</label>
                        <input type="text" name="catatan" value="{{ old('catatan') }}"
                            placeholder="Misal: RORIS rutin semester 1 2026" class="w-full border border-slate-200 rounded-xl px-3.5 py-2 text-sm
                                                  focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>
            </div>

            {{-- Tabel Detail Barang --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-slate-700">Rincian Barang</h2>
                    <button type="button" id="tambahBaris" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100
                                               text-emerald-700 text-xs font-semibold rounded-lg transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Baris
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm" id="tabelDetail">
                        <thead>
                            <tr class="bg-slate-50 text-xs text-slate-500 uppercase tracking-wider">
                                <th class="px-3 py-2.5 text-left rounded-tl-lg">Kode</th>
                                <th class="px-3 py-2.5 text-left">Nama Barang</th>
                                <th class="px-3 py-2.5 text-left">Satuan</th>
                                <th class="px-3 py-2.5 text-right">Qty Fisik</th>
                                <th class="px-3 py-2.5 text-right">Harga Modal (Rp)</th>
                                <th class="px-3 py-2.5 text-right">Harga Jual (Rp)</th>
                                <th class="px-3 py-2.5 text-right">Subtotal Modal</th>
                                <th class="px-3 py-2.5 text-right rounded-tr-lg">Subtotal Pend.</th>
                                <th class="px-3 py-2.5"></th>
                            </tr>
                        </thead>
                        <tbody id="tabelBody">
                            {{-- Render old input jika ada (setelah validasi gagal) --}}
                            @if (old('details'))
                                @foreach (old('details') as $i => $d)
                                    <tr class="border-t border-slate-100 baris-detail">
                                        <td class="px-2 py-2">
                                            <input type="text" name="details[{{ $i }}][kode_barang]"
                                                value="{{ $d['kode_barang'] ?? '' }}"
                                                class="input-kode w-24 border border-slate-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
                                        </td>
                                        <td class="px-2 py-2">
                                            <input type="text" name="details[{{ $i }}][nama_barang]"
                                                value="{{ $d['nama_barang'] ?? '' }}"
                                                class="w-36 border border-slate-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
                                        </td>
                                        <td class="px-2 py-2">
                                            <input type="text" name="details[{{ $i }}][satuan]" value="{{ $d['satuan'] ?? '' }}"
                                                class="w-20 border border-slate-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
                                        </td>
                                        <td class="px-2 py-2">
                                            <input type="number" name="details[{{ $i }}][qty_fisik]"
                                                value="{{ $d['qty_fisik'] ?? '' }}" min="0" step="0.01"
                                                class="input-qty w-20 border border-slate-200 rounded-lg px-2 py-1.5 text-xs text-right focus:outline-none focus:ring-1 focus:ring-blue-400">
                                        </td>
                                        <td class="px-2 py-2">
                                            <input type="number" name="details[{{ $i }}][harga_modal]"
                                                value="{{ $d['harga_modal'] ?? '' }}" min="0" step="1"
                                                class="input-modal w-28 border border-slate-200 rounded-lg px-2 py-1.5 text-xs text-right focus:outline-none focus:ring-1 focus:ring-blue-400">
                                        </td>
                                        <td class="px-2 py-2">
                                            <input type="number" name="details[{{ $i }}][harga_jual]"
                                                value="{{ $d['harga_jual'] ?? '' }}" min="0" step="1"
                                                class="input-jual w-28 border border-slate-200 rounded-lg px-2 py-1.5 text-xs text-right focus:outline-none focus:ring-1 focus:ring-blue-400">
                                        </td>
                                        <td class="px-2 py-2 text-right text-xs text-slate-600 subtotal-modal font-medium">0</td>
                                        <td class="px-2 py-2 text-right text-xs text-slate-600 subtotal-pend font-medium">0</td>
                                        <td class="px-2 py-2">
                                            <button type="button"
                                                class="hapus-baris text-rose-400 hover:text-rose-600 transition p-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                {{-- 1 baris kosong default --}}
                                <tr class="border-t border-slate-100 baris-detail">
                                    <td class="px-2 py-2">
                                        <input type="text" name="details[0][kode_barang]" placeholder="B001"
                                            class="input-kode w-24 border border-slate-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
                                    </td>
                                    <td class="px-2 py-2">
                                        <input type="text" name="details[0][nama_barang]" placeholder="Nama barang"
                                            class="w-36 border border-slate-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
                                    </td>
                                    <td class="px-2 py-2">
                                        <input type="text" name="details[0][satuan]" placeholder="Kg"
                                            class="w-20 border border-slate-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
                                    </td>
                                    <td class="px-2 py-2">
                                        <input type="number" name="details[0][qty_fisik]" placeholder="0" min="0" step="0.01"
                                            class="input-qty w-20 border border-slate-200 rounded-lg px-2 py-1.5 text-xs text-right focus:outline-none focus:ring-1 focus:ring-blue-400">
                                    </td>
                                    <td class="px-2 py-2">
                                        <input type="number" name="details[0][harga_modal]" placeholder="0" min="0" step="1"
                                            class="input-modal w-28 border border-slate-200 rounded-lg px-2 py-1.5 text-xs text-right focus:outline-none focus:ring-1 focus:ring-blue-400">
                                    </td>
                                    <td class="px-2 py-2">
                                        <input type="number" name="details[0][harga_jual]" placeholder="0" min="0" step="1"
                                            class="input-jual w-28 border border-slate-200 rounded-lg px-2 py-1.5 text-xs text-right focus:outline-none focus:ring-1 focus:ring-blue-400">
                                    </td>
                                    <td class="px-2 py-2 text-right text-xs text-slate-600 subtotal-modal font-medium">0</td>
                                    <td class="px-2 py-2 text-right text-xs text-slate-600 subtotal-pend font-medium">0</td>
                                    <td class="px-2 py-2">
                                        <button type="button"
                                            class="hapus-baris text-rose-400 hover:text-rose-600 transition p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Ringkasan Total --}}
                <div class="mt-5 pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:justify-end gap-4">
                    <div class="text-right">
                        <p class="text-xs text-slate-500">Total Modal</p>
                        <p id="previewTotalModal" class="text-sm font-bold text-slate-800">Rp 0</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-slate-500">Total Pendapatan</p>
                        <p id="previewTotalPend" class="text-sm font-bold text-slate-800">Rp 0</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-slate-500">Nilai RORIS</p>
                        <p id="previewNilai" class="text-sm font-bold text-emerald-600">Rp 0</p>
                    </div>
                </div>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('pemilik.roris.index') }}"
                    class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                    Simpan RORIS
                </button>
            </div>
        </form>
    </div>

    <script>
        (function () {
            const fmt = v => 'Rp ' + Number(v).toLocaleString('id-ID');

            // ── Hitung subtotal satu baris ──────────────────────────────────────────
            function hitungBaris(tr) {
                const qty = parseFloat(tr.querySelector('.input-qty')?.value) || 0;
                const modal = parseFloat(tr.querySelector('.input-modal')?.value) || 0;
                const jual = parseFloat(tr.querySelector('.input-jual')?.value) || 0;

                const stModal = qty * modal;
                const stPend = qty * jual;

                tr.querySelector('.subtotal-modal').textContent = fmt(stModal);
                tr.querySelector('.subtotal-pend').textContent = fmt(stPend);

                return { stModal, stPend };
            }

            // ── Hitung total semua baris ────────────────────────────────────────────
            function hitungTotal() {
                let totalModal = 0, totalPend = 0;
                document.querySelectorAll('.baris-detail').forEach(tr => {
                    const r = hitungBaris(tr);
                    totalModal += r.stModal;
                    totalPend += r.stPend;
                });
                const nilaiRoris = totalPend - totalModal;

                document.getElementById('previewTotalModal').textContent = fmt(totalModal);
                document.getElementById('previewTotalPend').textContent = fmt(totalPend);
                const elNilai = document.getElementById('previewNilai');
                elNilai.textContent = fmt(nilaiRoris);
                elNilai.className = 'text-sm font-bold ' + (nilaiRoris >= 0 ? 'text-emerald-600' : 'text-rose-600');
            }

            // ── Re-index nama field setelah baris ditambah/hapus ───────────────────
            function reIndex() {
                document.querySelectorAll('.baris-detail').forEach((tr, i) => {
                    tr.querySelectorAll('input[name]').forEach(inp => {
                        inp.name = inp.name.replace(/details\[\d+\]/, `details[${i}]`);
                    });
                });
            }

            // ── Template baris baru ─────────────────────────────────────────────────
            function buatBaris(idx) {
                const tr = document.createElement('tr');
                tr.className = 'border-t border-slate-100 baris-detail';
                tr.innerHTML = `
                            <td class="px-2 py-2">
                                <input type="text" name="details[${idx}][kode_barang]" placeholder="B001"
                                       class="input-kode w-24 border border-slate-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
                            </td>
                            <td class="px-2 py-2">
                                <input type="text" name="details[${idx}][nama_barang]" placeholder="Nama barang"
                                       class="w-36 border border-slate-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
                            </td>
                            <td class="px-2 py-2">
                                <input type="text" name="details[${idx}][satuan]" placeholder="Kg"
                                       class="w-20 border border-slate-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
                            </td>
                            <td class="px-2 py-2">
                                <input type="number" name="details[${idx}][qty_fisik]" placeholder="0" min="0" step="0.01"
                                       class="input-qty w-20 border border-slate-200 rounded-lg px-2 py-1.5 text-xs text-right focus:outline-none focus:ring-1 focus:ring-blue-400">
                            </td>
                            <td class="px-2 py-2">
                                <input type="number" name="details[${idx}][harga_modal]" placeholder="0" min="0" step="1"
                                       class="input-modal w-28 border border-slate-200 rounded-lg px-2 py-1.5 text-xs text-right focus:outline-none focus:ring-1 focus:ring-blue-400">
                            </td>
                            <td class="px-2 py-2">
                                <input type="number" name="details[${idx}][harga_jual]" placeholder="0" min="0" step="1"
                                       class="input-jual w-28 border border-slate-200 rounded-lg px-2 py-1.5 text-xs text-right focus:outline-none focus:ring-1 focus:ring-blue-400">
                            </td>
                            <td class="px-2 py-2 text-right text-xs text-slate-600 subtotal-modal font-medium">0</td>
                            <td class="px-2 py-2 text-right text-xs text-slate-600 subtotal-pend font-medium">0</td>
                            <td class="px-2 py-2">
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

            // ── Event: input berubah → hitung ulang ────────────────────────────────
            tbody.addEventListener('input', function (e) {
                if (e.target.matches('.input-qty, .input-modal, .input-jual')) {
                    hitungTotal();
                }
            });

            // ── Event: tombol Tambah Baris ──────────────────────────────────────────
            document.getElementById('tambahBaris').addEventListener('click', function () {
                const idx = document.querySelectorAll('.baris-detail').length;
                tbody.appendChild(buatBaris(idx));
            });

            // ── Event: tombol Hapus Baris ───────────────────────────────────────────
            tbody.addEventListener('click', function (e) {
                const btn = e.target.closest('.hapus-baris');
                if (!btn) return;
                const rows = document.querySelectorAll('.baris-detail');
                if (rows.length <= 1) {
                    alert('Minimal harus ada satu baris barang.');
                    return;
                }
                btn.closest('tr').remove();
                reIndex();
                hitungTotal();
            });

            // ── Hitung awal (saat ada old input) ───────────────────────────────────
            hitungTotal();
        })();
    </script>
@endsection