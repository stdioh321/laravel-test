<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarRole extends Model
{
    protected $table = 'car_role';
    protected $fillable = ['id_car', 'id_role'];

    function id_car()
    {
        return $this->belongsTo(Car::class,'id_car','id');
    }
}
