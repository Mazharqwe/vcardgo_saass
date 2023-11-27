<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appoinment extends Model
{
    use HasFactory;
    private static $appointmentData = null;
    private static $flagApp = false;
    protected $fillable = [
        'business_id',
        'content',
        'is_enabled',
        'created_by'
    ];

    public static function appointmentData($id)
    {
        if (self::$appointmentData == null) {
            if (self::$flagApp === false) {
                $appointmentDetail = appoinment::where('business_id', $id)->first();
                self::$appointmentData = $appointmentDetail;
                self::$flagApp = true;
            }
        }
        return self::$appointmentData;

    }
}
