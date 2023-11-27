<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    private static $galleryData = null;
    private static $flagGallery = false;
    protected $fillable = [
        'business_id',
        'content',
        'is_enabled',
        'created_by'
    ];
    public static function galleryData($id)
    {
        if(self::$galleryData == null) {
            if(self::$flagGallery === false){
                $galleryDetail=Gallery::where('business_id', $id)->first();
                self::$galleryData = $galleryDetail; 
                self::$flagGallery =  true;
            }       
        }
        return self::$galleryData;

    }
}