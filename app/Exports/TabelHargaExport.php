<?php

namespace App\Exports;

use App\Models\Pangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Coordinate;

class TabelHargaExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings, WithStyles
{
  
    protected $isAdmin;
    protected $filter;

    public function __construct($isAdmin, $filter)
    {
        $this->isAdmin = $isAdmin;
        $this->filter = $filter;
    }

    public function query()
    {
        $panganQuery = Pangan::query();

        if ($this->isAdmin) {
            if ($this->filter) {
                $panganQuery->where('pasar', 'like', '%' . $this->filter . '%');
            }
        } else {
            $operator = auth()->user()->operator;
            $panganQuery->where('pasar', $operator);
        }

        return $panganQuery->with(['barang.komoditas'])->orderBy('komoditas_id', 'ASC')->orderBy('barang_id', 'ASC')->orderBy('pasar')->orderBy('created_at', 'desc');
    }    

    public function headings(): array
    {
        return [
            'Pasar',
            'Komoditas',
            'Jenis Barang',   
            'Satuan',
            'Harga Lama',
            'Harga Sekarang',
            'Perubahan (Rp)',
            'Perubahan (%)',
            'Keterangan',
            'Periode'
        ];
    }

    public function map($pangan): array
    {
        if (!$pangan || !$pangan->barang || !$pangan->barang->komoditas) {
            return [];
        }

        return [
            $pangan->pasar,
            $pangan->barang->komoditas->nama,
            $pangan->barang->nama,
            $pangan->satuan,
            $pangan->harga_sebelum,
            $pangan->harga,
            $pangan->perubahan_rp,
            $pangan->perubahan_persen,
            $pangan->keterangan,
            Carbon::parse($pangan->periode)->format('d/M/Y')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
            'A1:J1' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            'A1:J' . $sheet->getHighestRow() => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $highestColumn = Coordinate::stringFromColumnIndex($sheet->getHighestColumn());

                // Mengatur border untuk seluruh sel di tabel
                $sheet->getStyle('A1:' . $highestColumn . $sheet->getHighestRow())->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
