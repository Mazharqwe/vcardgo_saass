<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;

    private static $contactData = null;
    private static $flagContact = false;
    protected $fillable = [
        'business_id',
        'content',
        'is_enabled',
        'created_by'
    ];

    public static function contactData($id)
    {
        if (self::$contactData == null) {
            if (self::$flagContact === false) {
                $contactDetail = ContactInfo::where('business_id', $id)->first();
                self::$contactData = $contactDetail;
                self::$flagContact = true;
            }
        }
        return self::$contactData;

    }
}
