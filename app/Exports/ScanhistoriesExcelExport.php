<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ScanhistoriesExcelExport implements FromCollection, WithHeadings
{
    protected $scanreportlog;

    public function __construct(Collection $scanreportlog)
    {
        $this->scanreportlog = $scanreportlog;
    }

    public function collection()
    {
        return $this->scanreportlog->map(function ($log) {
            return [
                'ID' => $log->id,
                'Product Name' => $log->product,
                'Batch' => is_object($log->batch) ? ($log->batch->code ?? 'N/A') : 'N/A',
                'IP Address' => $log->ip_address,
                'Qr code' => $log->qr_code,
                'Latitude' => $log->latitude, // Ensure these fields exist in your model
                'Longitude' => $log->longitude,
                'Mobile' => $log->mobile,
                'Scanned On' => $log->created_at->format('Y-m-d H:i:s'), // Format the date if needed
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Product Name',
            'Batch',
            'IP Address',
            'Qr code',
            'Latitude',
            'Longitude',
            'Mobile',
            'Scanned On'
        ];
    }
}
