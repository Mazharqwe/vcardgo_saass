<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment_deatail extends Model
{
    private static $appData=null;
    use HasFactory;
    protected $fillable = [
        'business_id',
        'name',
        'email',
        'phone',
        'date',
        'time',
        'status',
        'note',
        'created_by'
    ];
       public function getBussinessName(){
        if(self::$appData==null)
        {
            $business = Business::find($this->business_id);
            if(!empty($business)){
                self::$appData=$business->title;
            }else{
                return ' - ';
            }
            
        }
        return self::$appData;
    }
}
