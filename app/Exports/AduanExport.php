<?php

namespace App\Exports;

use App\Models\Aduan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AduanExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function query()
    {
        // if (request('periode')) {
        //     return Aduan::query()->where('created_at','like', '%' . request('periode') . '%')->orderBy('created_at', 'desc');
        // } 

        if (auth()->user()->is_admin == true) {
            return Aduan::query()->orderBy('created_at', 'desc');
        }elseif (auth()->user()->is_admin == false) {
            return Aduan::query()->where('pasar', auth()->user()->operator)->orderBy('created_at', 'desc');
        }
 
        //  return Aduan::query();
    }    

    public function headings(): array
    {
        return [
            'Nama',   
            'No_Hp',
            'Lokasi Pasar',
            'Isi_Aduan',
            'Tanggal'
        ];
    }

    public function map($aduan): array
    {

        
        return [
            $aduan->nama,
            $aduan->no_hp,
            $aduan->pasar,
            $aduan->isi_aduan,
            Carbon::parse($aduan->created_at)->format('d/M/Y'),
            
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
