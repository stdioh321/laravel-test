<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;
    protected $table = "cars";
    protected $fillable = [
        'name',
        'model',
        'color',
        'created_at',
        'updated_at',
        'deleted_at',
        'brand',
        'price',
    ];
    public function model()
    {
        return $this->belongsTo(CarModel::class, 'model', 'id');
    }
    public function brand(){
        return $this->belongsTo(Brand::class, 'brand', 'id');
    }
    public function ids(){
        return $this->hasMany(CarRole::class, 'id_car', 'id');
    }
}
