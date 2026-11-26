<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan RORIS {{ $dari }} s.d. {{ $sampai }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10px; color: #1e293b; }
        .header { text-align: center; margin-bottom: 18px; }
        .header h1 { font-size: 16px; font-weight: bold; color: #0f2b5c; }
        .header p  { font-size: 10px; color: #64748b; margin-top: 2px; }
        .meta { font-size: 9px; color: #475569; margin-bottom: 14px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        thead th {
            background: #dbeafe; color: #1e3a8a;
            padding: 6px 8px; text-align: left;
            font-size: 9px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.04em;
            border-bottom: 2px solid #93c5fd;
        }
        thead th.text-right { text-align: right; }
        tbody td { padding: 5px 8px; border-bottom: 1px solid #f1f5f9; vertical-align: top; }
        tbody tr:nth-child(even) td { background: #f8fafc; }
        .text-right { text-align: right; }
        tfoot td {
            padding: 6px 8px; font-weight: bold;
            border-top: 2px solid #93c5fd; background: #eff6ff;
        }
        .footer { margin-top: 20px; font-size: 9px; color: #94a3b8; text-align: right; }
        .badge-pos { color: #059669; font-weight: bold; }
        .badge-neg { color: #dc2626; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan RORIS — Toko Rizky (Kelola.in)</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($dari)->format('d-m-Y') }} s.d. {{ \Carbon\Carbon::parse($sampai)->format('d-m-Y') }}</p>
    </div>

    <div class="meta">
        Dicetak oleh: {{ auth()->user()?->name ?? '-' }} &nbsp;|&nbsp;
        Dicetak pada: {{ now()->format('d-m-Y H:i') }} WIB
    </div>

    @if ($rorisList->isEmpty())
        <p style="color:#94a3b8; text-align:center; padding: 30px 0;">
            Tidak ada data RORIS pada periode yang dipilih.
        </p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Dibuat Oleh</th>
                    <th class="text-right">Total Modal (Rp)</th>
                    <th class="text-right">Total Pendapatan (Rp)</th>
                    <th class="text-right">Nilai RORIS (Rp)</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rorisList as $r)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $r->tanggal->format('d-m-Y') }}</td>
                        <td>{{ $r->user?->name ?? '-' }}</td>
                        <td class="text-right">{{ number_format($r->total_modal, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($r->total_pendapatan, 0, ',', '.') }}</td>
                        <td class="text-right {{ $r->nilai_roris >= 0 ? 'badge-pos' : 'badge-neg' }}">
                            {{ number_format($r->nilai_roris, 0, ',', '.') }}
                        </td>
                        <td>{{ $r->catatan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right">Total Keseluruhan</td>
                    <td class="text-right">{{ number_format($totalModal, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                    <td class="text-right {{ $nilaiRoris >= 0 ? 'badge-pos' : 'badge-neg' }}">
                        {{ number_format($nilaiRoris, 0, ',', '.') }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    @endif

    <div class="footer">Kelola.in &bull; Sistem Informasi Toko Sembako &bull; Modul RORIS</div>
</body>
</html>
