<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'models';
    protected $fillable =[
        'name'
    ];

    public function cars()
    {
        return $this->hasMany(Car::class, 'model','id');
    }
    
}
