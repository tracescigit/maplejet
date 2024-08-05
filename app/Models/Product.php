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
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['brand', 'name', 'company_name','price', 'gtin', 'image','web_url','status'])
            ->logOnlyDirty()                      
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Product has been {$eventName}")
            ->useLogName('Product');                
    }
}
