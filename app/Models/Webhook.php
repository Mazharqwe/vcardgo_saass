<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    use HasFactory;
    protected $fillable = [
        'module',
        'method',
        'url',
        'created_by',
    ];

    public static $module= [
        'New User' => 'New User',
        'New Appointment' => 'New Appointment',
    ];
    public static $method= [
        'Get' => 'Get',
        'Post' => 'Post',
    ];
}
