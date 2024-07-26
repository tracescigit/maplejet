<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportLog extends Model
{
        use HasFactory;
        protected $table='reported_product_details';
        protected $fillable = [
            'reporter_id',
            'report_reason',
            'product',
            'batch',
            'image_path',
            'lat',
            'long',
            'mobile',
            'description',
            'ip'
        ];
}
