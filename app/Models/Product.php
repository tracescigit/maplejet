<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Product extends Model
{
    use HasFactory,LogsActivity;
    use SoftDeletes; 
    protected $fillable = [
        'brand',
        'name',
        'company_name',
        'slug',
        'unique_id',
        'gtin',
        'image',
        'label',
        'media',
        'web_url',
        'description',
        'custom_text',
        'auth_required',
        'bypass_conditions',
        'status',
        'deleted_at'
    ];
    public function qrcode()
    {
        return $this->hasOne(Qrcode::class, 'product_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['brand', 'name', 'company_name', 'price', 'gtin', 'image', 'web_url', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                // Define the log name here
                $logName = 'Product';
    
                switch ($eventName) {
                    case 'created':
                        return "{$logName} has been created with the following details: Brand - {$this->brand}, Name - {$this->name}, Company Name - {$this->company_name}, Price - {$this->price}, GTIN - {$this->gtin}, Image - {$this->image}, Web URL - {$this->web_url}, Status - {$this->status}";
                    case 'updated':
                        return "{$logName} has been updated. New details: Brand - {$this->brand}, Name - {$this->name}, Company Name - {$this->company_name}, Price - {$this->price}, GTIN - {$this->gtin}, Image - {$this->image}, Web URL - {$this->web_url}, Status - {$this->status}";
                    case 'deleted':
                        return "{$logName} with Name - {$this->name} has been deleted.";
                    default:
                        return "{$logName} has been {$eventName}.";
                }
            })
            ->useLogName('Product');
    }
    
}
