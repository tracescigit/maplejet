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
            ->logOnly(['code', 'ip_address', 'printer_name', 'name', 'mfg_date', 'exp_date', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                // Define the log name here
                $logName = 'Production Line';
    
                switch ($eventName) {
                    case 'created':
                        return "{$logName} has been created with the following details: Code - {$this->code}, IP Address - {$this->ip_address}, Printer Name - {$this->printer_name}, Name - {$this->name}, Manufacturing Date - {$this->mfg_date->format('d-m-Y')}, Expiry Date - {$this->exp_date->format('d-m-Y')}, Status - {$this->status}";
                    case 'updated':
                        return "{$logName} has been updated. New details: Code - {$this->code}, IP Address - {$this->ip_address}, Printer Name - {$this->printer_name}, Name - {$this->name}, Manufacturing Date - {$this->mfg_date->format('d-m-Y')}, Expiry Date - {$this->exp_date->format('d-m-Y')}, Status - {$this->status}";
                    case 'deleted':
                        return "{$logName} with Code - {$this->code} has been deleted.";
                    default:
                        return "{$logName} has been {$eventName}.";
                }
            })
            ->useLogName('Production Line');
    }
    
}
