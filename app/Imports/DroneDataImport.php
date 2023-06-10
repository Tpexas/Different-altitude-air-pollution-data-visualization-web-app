<?php

namespace App\Imports;

use App\Models\DroneData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class DroneDataImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
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
        return new DroneData([
            'date' => $row['CUSTOM.date [local]'],
            'time' => $row['CUSTOM.updateTime [local]'],
            'latitude' => $row['OSD.latitude'],
            'longitude' => $row['OSD.longitude'],
            'altitude' => $row['OSD.height [ft]'],
           'report_id' => $this->report_id,
        ]);
    }


    public function batchSize(): int
    {
        return 750;
    }

    public function chunkSize(): int
    {
        return 750;
    }
}
