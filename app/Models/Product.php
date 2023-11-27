<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    private static $productData = null;
    private static $flagProduct = false;
    protected $fillable = [
        'business_id',
        'content',
        'is_enabled',
        'created_by'
    ];

    public static function productData($id)
    {
        if(self::$productData == null) {
            if(self::$flagProduct === false){
                $productDetail=Product::where('business_id', $id)->first();
                self::$productData = $productDetail; 
                self::$flagProduct =  true;
            }       
        }
        return self::$productData;

    }
}
