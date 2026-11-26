{{--
Partial: Grafik RORIS untuk Dashboard Pemilik Toko (SKPL-F-19)
Di-include di resources/views/dashboard/pemilik.blade.php dengan:
@include('dashboard.partials.grafik-roris')
--}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mt-8">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-base font-bold text-slate-800">Grafik Nilai RORIS</h2>
            <p class="text-xs text-slate-400 mt-0.5">12 RORIS terakhir</p>
        </div>
        <a href="{{ route('pemilik.roris.index') }}" class="text-xs font-semibold text-blue-600 hover:underline">
            Lihat Semua →
        </a>
    </div>

    <div class="relative" style="height:220px;">
        <canvas id="grafikRorisChart"></canvas>
        <div id="grafikRorisEmpty"
            class="absolute inset-0 hidden flex items-center justify-center text-slate-400 text-sm font-medium">
            Belum ada data RORIS.
        </div>
    </div>

    <!-- Ringkasan angka terakhir -->
    <div id="grafikRorisStats" class="grid grid-cols-3 gap-4 mt-5 hidden">
        <div class="text-center">
            <p class="text-xs text-slate-500 mb-0.5">Total Modal</p>
            <p id="statModal" class="text-sm font-bold text-slate-800">Rp 0</p>
        </div>
        <div class="text-center">
            <p class="text-xs text-slate-500 mb-0.5">Total Pendapatan</p>
            <p id="statPendapatan" class="text-sm font-bold text-slate-800">Rp 0</p>
        </div>
        <div class="text-center">
            <p class="text-xs text-slate-500 mb-0.5">Nilai RORIS</p>
            <p id="statNilai" class="text-sm font-bold text-emerald-600">Rp 0</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    (function () {
        const endpoint = "{{ route('pemilik.grafik.roris') }}";

        fetch(endpoint, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(data => {
                const labels = data.labels ?? [];
                const values = data.values ?? [];

                if (labels.length === 0) {
                    document.getElementById('grafikRorisEmpty').classList.remove('hidden');
                    return;
                }

                document.getElementById('grafikRorisStats').classList.remove('hidden');

                const total = values.reduce((a, b) => a + b, 0);
                const fmt = v => 'Rp ' + Number(v).toLocaleString('id-ID');

                // Angka ringkasan (dari endpoint grafik kita hanya punya nilai_roris;
                // untuk tampilan sederhana tampilkan total nilai RORIS saja di stat utama)
                document.getElementById('statNilai').textContent = fmt(total);
                document.getElementById('statModal').textContent = '-';
                document.getElementById('statPendapatan').textContent = '-';

                const ctx = document.getElementById('grafikRorisChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Nilai RORIS (Rp)',
                            data: values,
                            backgroundColor: 'rgba(59,130,246,0.18)',
                            borderColor: 'rgba(59,130,246,0.85)',
                            borderWidth: 2,
                            borderRadius: 6,
                            hoverBackgroundColor: 'rgba(59,130,246,0.32)',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: ctx => ' Rp ' + Number(ctx.raw).toLocaleString('id-ID')
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: v => 'Rp ' + Number(v).toLocaleString('id-ID'),
                                    font: { size: 10 }
                                },
                                grid: { color: 'rgba(0,0,0,0.04)' }
                            },
                            x: {
                                ticks: { font: { size: 10 } },
                                grid: { display: false }
                            }
                        }
                    }
                });
            })
            .catch(() => {
                document.getElementById('grafikRorisEmpty').classList.remove('hidden');
            });
    })();
</script>