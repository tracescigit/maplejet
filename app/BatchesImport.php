<?php

namespace App\Imports;

use App\Models\Batch;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BatchesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Batch([
            'product_id' => $row['product_id'],
            'code' => $row['code'],
            'currency' => $row['currency'],
            'price' => $row['price'],
            'mfg_date' => $row['mfg_date'],
            'exp_date' => $row['exp_date'],
            'remarks' => $row['remarks'],
            'status' => $row['status'],
        ]);
    }
}