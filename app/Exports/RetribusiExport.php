<?php

namespace App\Exports;

use App\Models\Aduan;
use App\Models\Retribusi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RetribusiExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    protected $retribusi;
    protected $date;

    public function __construct($retribusi, $date)
    {
        $this->retribusi = $retribusi;
        $this->date = $date;
    }

    public function query()
    {
        $query = Retribusi::query()
                          ->whereDate('created_at', $this->date)
                          ->orderBy('created_at', 'desc');

        if (!auth()->user()->is_admin) {
            $query->where('pasar_id', auth()->user()->pasar_id);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Tanggal',   
            'Pasar',
            'Nama Pedagang',
            'Alamat',
            'Jenis Retribusi',
            'Jumlah Pembayaran',
            'Metode Pembayaran',
            'No Pembayaran',
            'Keterangan',
            'Petugas Penerima'
        ];
    }

    public function map($retribusi): array
    {

        return [
            Carbon::parse($retribusi->created_at)->format('d/M/Y'),
            $retribusi->pasar->nama,
            $retribusi->nama_pedagang,
            $retribusi->alamat,
            $retribusi->jenis_retribusi,
            $retribusi->jumlah_pembayaran,
            $retribusi->metode_pembayaran,
            $retribusi->no_pembayaran,
            $retribusi->keterangan,
            $retribusi->user->name
            
        ];
    }

    
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

           
        ];
    }
}
