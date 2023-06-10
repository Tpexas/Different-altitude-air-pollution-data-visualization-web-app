<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataExport implements FromCollection, WithHeadings
{
    public $droneAndSensorData;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function  __construct($droneAndSensorData)
    {
        $this->droneAndSensorData = $droneAndSensorData;
    }


    public function collection()
    {
        return $this->droneAndSensorData;
    }

    public function headings(): array{
    return[
        'Data', 'Laikas', 'CO2 PPM', 'SO2 µg/m3', 'NO2 µg/m3', 'KD10 µg/m3', 'KD2.5 µg/m3', 'O3 µg/m3',
        'CO µg/m3', 'Temperatūra °C', 'Drėgmė %', 'Drono ilguma', 'Drono platuma', 'Drono aukštis m',
    ];
}

}
