<?php

namespace App\Imports;

use App\Models\SensorData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SensorDataImport implements ToModel, WithHeadingRow
{
    private $report_id;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function  __construct($report_id)
    {
        $this->report_id= $report_id;
    }

    public function model(array $row)
    {
        return new SensorData([
            'time'     => $row['time'],
           'sensor1'    => $row['sensor1'],
           'temperature'    => $row['temperature'],
           'humidity'    => $row['humidity'],
           'report_id' => $this->report_id,
           'so2'    => $row['so2'],
           'no2'    => $row['no2'],
           'pm10'    => $row['pm10'],
           'pm2_5'    => $row['pm2_5'],
           'o3'    => $row['o3'],
           'co'    => $row['co'],
        ]);
    }
}
