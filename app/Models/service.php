<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class service extends Model
{
    use HasFactory;
    private static $serviceData = null;
    private static $flagService = false;
    protected $fillable = [
        'business_id',
        'content',
        'is_enabled',
        'created_by'
    ];

    public static function serviceData($id)
    {
        if(self::$serviceData == null) {
            if(self::$flagService === false){
                $serviceDetail=service::where('business_id', $id)->first();
                self::$serviceData = $serviceDetail; 
                self::$flagService =  true;
            }       
        }
        return self::$serviceData;

    }
}
