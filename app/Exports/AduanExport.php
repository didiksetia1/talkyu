<?php

namespace App\Exports;

use App\Models\Aduan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AduanExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
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
        $query = Aduan::with('user')->latest();

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

        $aduans = $query->get();

        return $aduans->map(function ($aduan, $index) {
            return [
                $index + 1,
                $aduan->judul ?? '-',
                $aduan->kategori ?? '-',
                $aduan->deskripsi ?? '-',
                $aduan->user?->name ?? 'Anonim',
                $aduan->created_at ? $aduan->created_at->format('d/m/Y') : '-',
                ucfirst(str_replace('_', ' ', $aduan->status)),
                $aduan->tanggapan ?? '-',
                $aduan->updated_at ? $aduan->updated_at->format('d/m/Y') : '-',
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
            'Tanggapan',
            'Tgl Tanggapan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header style
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

        // Data cell style
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

        // Apply header style
        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);

        // Apply data style to all data rows
        $lastRow = $sheet->getHighestRow();
        if ($lastRow > 1) {
            $sheet->getStyle("A2:I{$lastRow}")->applyFromArray($dataStyle);
        }

        // Row height for header
        $sheet->getRowDimension(1)->setRowHeight(25);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,   // No
            'B' => 30,  // Judul
            'C' => 15,  // Kategori
            'D' => 50,  // Deskripsi
            'E' => 20,  // Pengirim
            'F' => 12,  // Tanggal
            'G' => 12,  // Status
            'H' => 40,  // Tanggapan
            'I' => 14,  // Tgl Tanggapan
        ];
    }
}
