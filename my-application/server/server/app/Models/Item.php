<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Item extends Model
{

    use SoftDeletes;

    protected $table = 'items';
    protected $fillable = [
        'name',
        'price',
        'color',
        'id_brand',
        'id_model'
    ];
    protected $dates = ['created_at', 'updated_at'];
    protected $hidden = ['deleted_at'];

    // protected $casts = [
    //     'created_at' => 'datetime:Y-m-d H:m:i',
    //     'updated_at' => 'datetime:Y-m-d H:m:i',
    // ];

    // public function getCreatedAtAttribute($value)
    // {
    //     $c = Carbon::parse($value, 'America/Sao_Paulo')->format('Y-m-d');
    //     return $value;
    // }
    // public function setCreatedAtAttribute($value)
    // {
    //     $c = Carbon::now()->format('Y-m-d');
    //     $this->attributes['created_at'] = $c;
    // }


    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand', 'id');
    }
    public function model()
    {
        return $this->belongsTo(ModelM::class, 'id_model', 'id');
    }
    public function parts()
    {
        //INSERT INTO parts(id_item,name,description,created_at,updated_at) VALUES(3,'Plastic','Transparent',NOW(),NOW());
        return $this->hasMany(Part::class, 'id_item', 'id');
    }
}
