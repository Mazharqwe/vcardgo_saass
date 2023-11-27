<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class testimonial extends Model
{
    use HasFactory;
    private static $testimonialData = null;
    private static $flagTestimonial = false;
    protected $fillable = [
        'business_id',
        'content',
        'is_enabled',
        'created_by'
    ];

    public static function testimonialData($id)
    {
        if(self::$testimonialData == null) {
            if(self::$flagTestimonial === false){
                $testDetail=testimonial::where('business_id', $id)->first();
                self::$testimonialData = $testDetail; 
                self::$flagTestimonial =  true;
            }       
        }
        return self::$testimonialData;

    }
}
