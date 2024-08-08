<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Batch extends Model
{
    use HasFactory,LogsActivity;
    use SoftDeletes;
    protected static $logAttributes=['product_id','code','currency','price','mfg_date','mfg_date','exp_date','status'];

    protected $table='batches';
    protected $fillable = [
        'product_id',
        'code',
        'currency',
        'price',
        'mfg_date',
        'exp_date',
        'remarks',
        'status',
    ];

    /**
     * Get the product that owns the batch.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function qrcodes()
    {
        return $this->hasMany(Qrcode::class, 'batch_id');
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['product_id', 'code', 'currency','price', 'mfg_date', 'exp_date','status'])
            ->logOnlyDirty()                      
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Batch has been {$eventName}")
            ->useLogName('Batch');                
    }
    
}
