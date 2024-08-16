<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Qrcode extends Model
{
    use HasFactory,LogsActivity;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'aggregation_id',
        'code_type',
        'product_id',
        'url',
        'gs1_link',
        'qr_code',
        'batch',
        'batch_id',
        'code_data',
        'key',
        'status',
        'job_id',
        'printed',
        'print_count',
        'print_template',
        'print_time',
        'seized_by',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['deleted_at'];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id','id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['url', 'gs1_link', 'qr_code', 'batch', 'batch_id', 'code_data', 'printed', 'job_id', 'print_count', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                // Define the log name here
                $logName = 'Qrcode';
    
                switch ($eventName) {
                    case 'created':
                        return "{$logName} has been created with the following details: URL - {$this->url}, GS1 Link - {$this->gs1_link}, QR Code - {$this->qr_code}, Batch - {$this->batch}, Batch ID - {$this->batch_id}, Code Data - {$this->code_data}, Printed - {$this->printed}, Job ID - {$this->job_id}, Print Count - {$this->print_count}, Status - {$this->status}";
                    case 'updated':
                        return "{$logName} has been updated. New details: URL - {$this->url}, GS1 Link - {$this->gs1_link}, QR Code - {$this->qr_code}, Batch - {$this->batch}, Batch ID - {$this->batch_id}, Code Data - {$this->code_data}, Printed - {$this->printed}, Job ID - {$this->job_id}, Print Count - {$this->print_count}, Status - {$this->status}";
                    case 'deleted':
                        return "{$logName} with QR Code - {$this->qr_code} has been deleted.";
                    default:
                        return "{$logName} has been {$eventName}.";
                }
            })
            ->useLogName('Qrcode');
    }
    
    
}

