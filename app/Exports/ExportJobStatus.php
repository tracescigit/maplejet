<?php

namespace App\Exports;

use App\Models\ProductionJob;
use App\Models\Qrcode;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ExportJobStatus implements FromCollection, WithHeadings
{
    protected $jobSelect;
    protected $statusSelect;

    public function __construct($jobSelect, $statusSelect)
    {
        $this->jobSelect = $jobSelect;
        $this->statusSelect = $statusSelect;
    }

    public function collection()
    {
        $result_job = ProductionJob::where('id', $this->jobSelect)->first();
        $data_for_excel = collect(); // Initialize as an empty collection
        $start_code = $result_job->start_code;
        $end_code = intval($start_code) + intval($result_job->quantity);
        if ($this->statusSelect == 'all') {

            $data_for_excel = Qrcode::select('url', 'code_data', 'printed', 'seized_by')
                ->whereBetween('code_data', [$start_code, $end_code])
                ->get();
        } else if ($this->statusSelect == 'printed') {
            $data_for_excel = Qrcode::select('url', 'code_data', 'printed', 'seized_by')
                ->whereBetween('code_data', [$start_code, $end_code])
                ->where('printed', 1)
                ->get();
        } else if ($this->statusSelect == 'not_printed') {
            $data_for_excel = Qrcode::select('url', 'code_data', 'printed', 'seized_by')
                ->whereBetween('code_data', [$start_code, $end_code])
                ->where('printed', 0)
                ->get();
        } else if ($this->statusSelect == 'verified') {
            $data_for_excel = Qrcode::select('url', 'code_data', 'printed', 'seized_by')
                ->whereBetween('code_data', [$start_code, $end_code])
                ->where('seized_by', 1)
                ->get();
        } else {
            $data_for_excel = Qrcode::select('url', 'code_data', 'printed', 'seized_by')
                ->whereBetween('code_data', [$start_code, $end_code])
                ->where('seized_by', 0)
                ->get();
        }


        $data = [];
        foreach ($data_for_excel as $singledata) {
            $data[] = [
                'Job Code' => $result_job->code,
                'Url' => $singledata->url,
                'Qr Code' => $singledata->code_data,
                'Printed' => $singledata->printed == 0 ? 'Not Printed' : 'Printed',
                'Verified' => $singledata->seized_by == 0 ? 'Not Verified' : 'Verified',
                'Job Status' => $result_job->status,
            ];
        }

        return new Collection($data);
    }

    public function headings(): array
    {
        return [
            'Job Code',
            'Url',
            'Qr Code',
            'Printed',
            'Verified',
            'Job Status'
        ];
    }
}
