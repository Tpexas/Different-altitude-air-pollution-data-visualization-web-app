<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{

    protected $guarded = [];  
    use HasFactory;

    public function sensor_data(){
        return $this->hasMany(SensorData::class);
    }

    public function drone_data(){
        return $this->hasMany(DroneData::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeFilter($query, array $filters){
        if($filters['search'] ?? false){
            $query->where('pavadinimas', 'like', '%' .request('search') . '%') 
            ->orWhere('aprasymas', 'like', '%' .request('search') . '%');
        }
    }
}
