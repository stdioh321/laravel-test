<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Part extends Model
{

    use SoftDeletes;
    protected $table = "parts";
    protected $fillable = [
        'id_item',
        'name',
        'description'
    ];
    // protected $hidden = ['deleted_at','name'];


    function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id');
    }
}
