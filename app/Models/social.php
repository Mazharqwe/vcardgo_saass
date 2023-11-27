<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class social extends Model
{
    use HasFactory;
    private static $socialData = null;
    private static $flagSocial = false;
    protected $fillable = [
        'business_id',
        'content',
        'is_enabled',
        'created_by'
    ];

    public static function socialData($id)
    {
        if(self::$socialData == null) {
            if(self::$flagSocial === false){
                $socialDetail=social::where('business_id', $id)->first();
                self::$socialData = $socialDetail; 
                self::$flagSocial =  true;
            }       
        }
        return self::$socialData;

    }
}
