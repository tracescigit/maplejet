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
            ->setDescriptionForEvent(fn(string $eventName) => "Production Plant has been {$eventName}")
            ->useLogName('Production Plant');                
    }
}
