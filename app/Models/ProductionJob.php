<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class ProductionJob extends Model
{
    use HasFactory,LogsActivity;
    protected $fillable = [
        'code',
        'plant_id',
        'line_id',
        'start_code',
        'quantity',
        'repeat',
        'repeat_quantity',
        'printed',
        'verified',
        'status',
        'current_status',
        'assigned_at',
        'log'
    ];

    protected $casts = [
        'assigned_at' => 'datetime'
    ];
    public function productionplant()
    {
        return $this->belongsTo(ProductionPlant::class, 'plant_id', 'id');
    }

    public function productionLines()
    {
        return $this->belongsTo(ProductionLines::class, 'line_id');
    }
    public function qrcode()
    {
        return $this->belongsTo(Qrcode::class, 'start_code', 'code_data');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['start_code', 'code', 'quantity','status'])
            ->logOnlyDirty()                      
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Production has been {$eventName}")
            ->useLogName('ProductionJob');                
    }
}
