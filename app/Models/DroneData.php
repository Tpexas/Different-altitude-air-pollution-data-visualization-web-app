<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DroneData extends Model
{
    protected $guarded = []; 
    use HasFactory;

    public function report(){
        return $this->belongsTo(Report::class);
    }


}
