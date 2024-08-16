<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Carbon\Carbon;

class Batch extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    // Define log attributes
    protected static $logAttributes = ['product_id', 'code', 'currency', 'price', 'mfg_date', 'exp_date', 'status'];

    // Specify the table name
    protected $table = 'batches';

    // Define fillable attributes
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

    // Automatically cast to Carbon instances
    protected $dates = ['mfg_date', 'exp_date'];

    // Define relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function qrcodes()
    {
        return $this->hasMany(Qrcode::class, 'batch_id');
    }
    public function getMfgDateAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getExpDateAttribute($value)
    {
        return Carbon::parse($value);
    }
    // Configure activity logging options
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['product_id', 'code', 'currency', 'price', 'mfg_date', 'exp_date', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
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
