<?php

namespace App\Exports;

use App\Models\Roris;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanRorisExport implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(
        private readonly string $dari,
        private readonly string $sampai
    ) {
    }

    public function title(): string
    {
        return 'Laporan RORIS';
    }

    public function collection(): Collection
    {
        $rorisList = Roris::with('user')
            ->whereDate('tanggal', '>=', $this->dari)
            ->whereDate('tanggal', '<=', $this->sampai)
            ->orderBy('tanggal')
            ->get();

        return $rorisList->map(fn($r, $i) => [
            'No' => $i + 1,
            'No. RORIS' => '#RORIS-' . str_pad($r->id, 4, '0', STR_PAD_LEFT),
            'Tanggal' => $r->tanggal->format('d-m-Y'),
            'Dibuat Oleh' => $r->user?->name ?? '-',
            'Total Modal' => (float) $r->total_modal,
            'Total Pendapatan' => (float) $r->total_pendapatan,
            'Nilai RORIS' => (float) $r->nilai_roris,
            'Catatan' => $r->catatan ?? '-',
        ]);
    }

    public function headings(): array
    {
        return ['No', 'No. RORIS', 'Tanggal', 'Dibuat Oleh', 'Total Modal (Rp)', 'Total Pendapatan (Rp)', 'Nilai RORIS (Rp)', 'Catatan'];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DBEAFE']],
            ],
        ];
    }
}
