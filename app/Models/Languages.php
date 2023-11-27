<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Languages extends Model
{
    use HasFactory;
    protected $table = 'language';
    protected $fillable = [
        'code',
        'fullName',
    ];

    public static function languageData($code)
    {
        $cacheKey = 'language_data_' . $code;

        return cache()->remember($cacheKey, now()->addHours(24), function () use ($code) {
            return Languages::where('code', $code)->first();
        });
    }
}
