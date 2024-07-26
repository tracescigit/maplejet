<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedProductsModel extends Model
{
    use HasFactory;

    protected $table = 'reported_product_details';
    protected $fillable = ['lat', 'long', 'reporter_id','report_reason','image_path','description','mobile']; 
}
