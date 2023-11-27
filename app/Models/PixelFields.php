<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PixelFields extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_id',
        'platform',
        'pixel_id',
        'created_by'
    ];
    
}
