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
            ->logOnly(['url', 'gs1_link', 'qr_code','batch','batch_id','code_data','printed','job_id','print_count','status'])
            ->logOnlyDirty()                      
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Qrcode has been {$eventName}")
            ->useLogName('Qrcode');                
    }
    
}

