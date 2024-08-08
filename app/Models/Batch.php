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
            ->logOnly(['product_id', 'code', 'currency', 'price', 'mfg_date', 'exp_date', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                // Define the log name here
                $logName = 'Batch';
    
                switch ($eventName) {
                    case 'created':
                        return "{$logName} has been created with the following details: Product ID - {$this->product_id}, Code - {$this->code}, Currency - {$this->currency}, Price - {$this->price}, Manufacturing Date - {$this->mfg_date->format('d-m-Y')}, Expiry Date - {$this->exp_date->format('d-m-Y')}, Status - {$this->status}";
                    case 'updated':
                        return "{$logName} has been updated. New details: Product ID - {$this->product_id}, Code - {$this->code}, Currency - {$this->currency}, Price - {$this->price}, Manufacturing Date - {$this->mfg_date->format('d-m-Y')}, Expiry Date - {$this->exp_date->format('d-m-Y')}, Status - {$this->status}";
                    case 'deleted':
                        return "{$logName} with Code - {$this->code} has been deleted.";
                    default:
                        return "{$logName} has been {$eventName}.";
                }
            })
            ->useLogName('Batch');
    }
    
}
