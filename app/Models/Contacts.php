<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;

    private static $conData=null;
    protected $fillable = [
        'business_id',
        'name',
        'email',
        'phone',
        'message',
        'created_by'
    ];

    public static function getBusinessData($id)
    {
        if(self::$conData==null)
        {
            $business=Business::where('id', $id)->pluck('title')->first();
            self::$conData=$business;
        }
        return self::$conData;
    }
}
