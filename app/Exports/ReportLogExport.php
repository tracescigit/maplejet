<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Font;
class ReportLogExport implements FromCollection, WithHeadings
{
    protected $reportlog;
    protected $user;

    public function __construct($reportlog,$user)
    {
        $this->reportlog = $reportlog;
        $this->user = $user;
        
    }

    public function collection()
    {
        return $this->reportlog->map(function ($log) {
            $properties = json_decode($log->properties, true);

            // Separate the attributes and old sections for user view
            $attributes = isset($properties['attributes']) ? $properties['attributes'] : [];
            $old = isset($properties['old']) ? $properties['old'] : [];

            // Prepare readable strings for attributes and old
            $attributesStr = $this->prepareReadableString($attributes);
            $oldStr = $this->prepareReadableString($old);
            return [
                'ID' => $log->id,
                'Product Name'=>$log->product,
                'Batch'=>$log->batch,
                'Report Reason' => $log->report_reason,
                'Description' => $log->description,
                'Latitude' => $log->lat,
                'Longitude'=>$log->long,
                'Mobile' => $log->mobile,
                'IP' => $log->ip,
                
                 
            ];
        });
    }


    public function headings(): array
    {
        return [
            'ID',
            'Product Name',
            'Batch',
            'Issue',
            'Description',
            'Latitude',
            'Longitude',
            'Mobile',
            'IP'
        ];
    }
    private function prepareReadableString($data)
    {
        if (empty($data)) {
            return '';
        }

        $result = '';
        foreach ($data as $key => $value) {
            $result .= $key . ': ' . $value . PHP_EOL;
        }

        return $result;
    }
    public function styles($sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Make the first row (headings) bold
        ];
    }
}
