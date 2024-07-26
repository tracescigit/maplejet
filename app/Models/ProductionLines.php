<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductionPlant;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class ProductionLines extends Model
{
    use HasFactory,LogsActivity;

    protected $fillable = [
        'plant_id',
        'code',
        'ip_address',
        'printer_name',
        'name',
        'status',
        'ip_printer',
        'port_printer',
        'ip_camera',
        'port_camera',
        'ip_plc',
        'port_plc',
        'printer_id',
        'auth_token'

    ];

    public function productionplant()
    {
        return $this->belongsTo(ProductionPlant::class,'id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['code', 'ip_address', 'printer_name','name', 'mfg_date', 'exp_date','status'])
            ->logOnlyDirty()                      
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Production Line has been {$eventName}")
            ->useLogName('Production Line');                
    }
}
