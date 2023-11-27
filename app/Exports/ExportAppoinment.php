<?php

namespace App\Exports;

use App\Models\Appointment_deatail;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportAppoinment implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Appointment_deatail::all();
    }
}
