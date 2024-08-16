<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SystemAlertExcel implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $systemalerts;

    public function __construct($systemalerts)
    {
        $this->systemalerts = $systemalerts;
    }

    public function collection()
    {
        // Limit the number of rows to 5000
        $limitedData = $this->systemalerts->take(5000);

        return $limitedData->map(function ($log) {
            $batchname = $log->batches ? $log->batches->code : 'Unknown';
            return [
                'ID' => $log->id,
                'Product Name' => $log->product,
                'Batch' => $batchname, // Handling possible null value
                'Reason' => $log->report_reason,
                'Latitude' => $log->latitude,
                'Longitude' => $log->longitude,
                'IP' => $log->ip,
                'Date' => $log->created_at->format('d-m-Y H:i:s') // Simplified date formatting
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Product Name',
            'Batch',
            'Reason',
            'Latitude',
            'Longitude',
            'IP',
            'Date'
        ];
    }
}
