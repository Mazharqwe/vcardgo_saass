<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Businessqr extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_id',
        'foreground_color',
        'background_color',
        'radius',
        'qr_type',
        'qr_text',
        'qr_text_color',
        'image',
        'size',
    ];
}
