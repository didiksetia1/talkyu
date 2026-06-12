<?php

namespace App\Exports;

use App\Models\Aspirasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AspirasiExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $status;
    protected $kategori;
    protected $search;

    public function __construct($status = null, $kategori = null, $search = null)
    {
        $this->status = $status;
        $this->kategori = $kategori;
        $this->search = $search;
    }

    public function collection()
    {
        $query = Aspirasi::with(['user', 'event'])->latest();

        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }

        if (!empty($this->kategori)) {
            $query->where('kategori', $this->kategori);
        }

        if (!empty($this->search)) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $aspirasis = $query->get();

        return $aspirasis->map(function ($aspirasi, $index) {
            $statusLabel = match ($aspirasi->status) {
                'submitted' => 'Belum Ditinjau',
                'being_considered' => 'Diproses',
                'realized' => 'Selesai',
                default => ucfirst(str_replace('_', ' ', $aspirasi->status)),
            };

            return [
                $index + 1,
                $aspirasi->judul ?? '-',
                Aspirasi::CATEGORIES[$aspirasi->kategori] ?? ($aspirasi->kategori ?? '-'),
                $aspirasi->deskripsi ?? '-',
                $aspirasi->user?->name ?? 'Anonim',
                $aspirasi->created_at ? $aspirasi->created_at->format('d/m/Y') : '-',
                $statusLabel,
                $aspirasi->votes_count ?? 0,
                $aspirasi->comments_count ?? 0,
                $aspirasi->bem_response ?? '-',
                $aspirasi->updated_at ? $aspirasi->updated_at->format('d/m/Y') : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Judul',
            'Kategori',
            'Deskripsi',
            'Pengirim',
            'Tanggal',
            'Status',
            'Votes',
            'Komentar',
            'Response BEM',
            'Tgl Response',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1F2937'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D1D5DB'],
                ],
            ],
        ];

        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_TOP,
                'wrapText' => true,
            ],
        ];

        $sheet->getStyle('A1:K1')->applyFromArray($headerStyle);

        $lastRow = $sheet->getHighestRow();
        if ($lastRow > 1) {
            $sheet->getStyle("A2:K{$lastRow}")->applyFromArray($dataStyle);
        }

        $sheet->getRowDimension(1)->setRowHeight(25);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,   // No
            'B' => 30,  // Judul
            'C' => 20,  // Kategori
            'D' => 50,  // Deskripsi
            'E' => 20,  // Pengirim
            'F' => 12,  // Tanggal
            'G' => 14,  // Status
            'H' => 8,   // Votes
            'I' => 10,  // Komentar
            'J' => 40,  // Response BEM
            'K' => 14,  // Tgl Response
        ];
    }
}
