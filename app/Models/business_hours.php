<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class business_hours extends Model
{
    use HasFactory;
    private static $businessHourData = null;
    private static $flag = false;
    protected $fillable = [
        'business_id',
        'content',
        'is_enabled',
        'created_by'
    ];

    public static $days = [
        'sun' => 'Sunday',
        'mon' => 'Monday',
        'tue' => 'Tuesday',
        'wed' => 'Wednesday',
        'thu' => 'Thursday',
        'fri' => 'Friday',
        'sat' => 'Saturday',
    ];

    public static function businessHour($id)
    {
        if (self::$businessHourData == null) {
            if (self::$flag === false) {
                $business_hours = business_hours::where('business_id', $id)->first();
                self::$businessHourData = $business_hours;
                self::$flag = true;
            }


        }
        return self::$businessHourData;
    }

}
