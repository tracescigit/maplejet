<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'code_id', 'product', 'batch', 'genuine', 'phone_code', 'phone',
        'location', 'scan_count', 'scanned_by', 'device_id', 'ip_address',
        'feedback', 'images','product_id','qr_code','user_id'
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch', 'id');
    }
}