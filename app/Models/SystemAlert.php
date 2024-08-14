<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemAlert extends Model
{
    use HasFactory;

    // Specify the table associated with the model if it differs from the plural form of the model name
    protected $table = 'systemalerts';

    // Define which attributes can be mass-assigned
    protected $fillable = [
        'product',
        'batch',
        'city',
        'country',
        'reporter_id',
        'report_reason',
        'image_path',
        'lat',
        'long',
        'mobile',
        'description',
        'ip',
    ];
    public function batches()
    {
        return $this->belongsTo(Batch::class, 'batch','id');
    }
    // If timestamps are not used in the table, set this to false
    public $timestamps = true; // Set to false if you do not use `created_at` and `updated_at`

    // Define any relationships here, if applicable
    // Example:
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
