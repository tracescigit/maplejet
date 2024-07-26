<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Qrcode;
use Illuminate\Support\Facades\Storage;
use SplFileObject;

class ExportDataToCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id_to_start;
    protected $id_to_end;
    protected $fileName;


    public function __construct($id_to_start, $id_to_end, $fileName)
    {
        $this->id_to_start = $id_to_start;
        $this->id_to_end = $id_to_end;
        $this->fileName = $fileName;
    }
  
    public function handle()
    {
        $data = Qrcode::whereBetween('id', [$this->id_to_start, $this->id_to_end])->get();
    
        // Create CSV content
        $csvContent = '';
        $csvContent .= "id,aggregation_id,code_type,product_id,url,gs1_link,qr_code,batch,batch_id,code_data,key,status,job_id\n";
        foreach ($data as $row) {
            $csvContent .= "{$row->id},{$row->aggregation_id},{$row->code_type},{$row->product_id},{$row->url},{$row->gs1_link},{$row->qr_code},{$row->batch},{$row->batch_id},{$row->code_data},{$row->key},{$row->status},{$row->job_id}\n";
        }
        Storage::disk('local')->put('exports/' . $this->fileName, $csvContent);
    }
}
