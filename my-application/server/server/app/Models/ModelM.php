<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelM extends Model
{
    use SoftDeletes;
    protected $table = "models";

    protected $fillable = [
        'name',
        'id_brand'
    ];
    function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand', 'id');
    }
}
