<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class ProductionPlant extends Model
{
    use HasFactory,LogsActivity;
    use SoftDeletes; 
    protected $fillable = [
        'code',
        'name',
        'status',
    ];
    
    public function productionLines()
    {
        return $this->belongsTo(ProductionLines::class, 'plant_id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['code', 'name', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                switch ($eventName) {
                    case 'created':
                        return "A new Production Plant has been created with the following details: Code - {$this->code}, Name - {$this->name}, Status - {$this->status}";
                    case 'updated':
                        return "Production Plant has been updated. New details: Code - {$this->code}, Name - {$this->name}, Status - {$this->status}";
                    case 'deleted':
                        return "Production Plant with Code - {$this->code} has been deleted.";
                    default:
                        return "Production Plant has been {$eventName}.";
                }
            })
            ->useLogName('Production Plant');
    }
}
