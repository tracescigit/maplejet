<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Illuminate\Support\Collection;
use App\Models\Qrcode;
class JobDataExpot implements FromCollection, WithHeadings
{
    protected $datatoexcel;
    protected $datareq;

    public function __construct($datatoexcel,$datareq)
    {
        $this->datatoexcel = $datatoexcel;
        $this->datareq = $datareq;
        
    }

    public function collection()
    {
     $id_to_start=$this->datareq['id'];
     $id_to_end=$id_to_start + $this->datareq['quantity'];
     $urls = Qrcode::whereBetween('id', [$id_to_start, $id_to_end])->pluck('url')->toArray();

     
     $data = [];
     foreach ($urls as $url) {
         $data[] = [
             'price' => $this->datatoexcel['price'],
             'mfg_date' => $this->datatoexcel['mfg_date'],
             'exp_date' => $this->datatoexcel['exp_date'],
             'url' => $url,
             'gtin'=>$this->datatoexcel['gtin']
         ];
     }

     return new Collection($data);

    }


    public function headings(): array
    {
        return [
            'price',
            'mfg_date',
            'exp_date',
            'url',
            'gtin'
        ];
    }
   
   
}
